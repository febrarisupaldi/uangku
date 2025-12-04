<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ExpenseController extends Controller
{
    public function index(Request $request){
        $from = $request->input('from', date("Y-m-01"));
        $to = $request->input('to', date("Y-m-d"));

        $expenses = DB::table("uangku.expenses" , "e")
            ->where("e.user_id", "=", Auth::user()->id)
            ->whereBetween("e.expense_date", [$from, $to])
            ->join("uangku.users as u", "e.user_id", "=", "u.id")
            ->join("uangku.payments as w", "e.payment_id", "=", "w.id")
            ->leftJoin("uangku.wallets as wd", "w.id", "=", "wd.payment_id")
            ->leftJoin("uangku.debts as d", "e.payment_id", "=", "d.id")
            ->select("e.*", "u.name as user_name", 
                DB::raw("ifnull(wd.name,d.name) as wallet_name")
            )
            ->get();
        return view('expenses.index', compact('expenses', 'from', 'to'));
    }

    public function create(){
        $users = DB::table('uangku.users');
        if(Auth::user()->user_category_id == 2){
            $users = $users->where("users.id","=",Auth::user()->id);
        }
        $users = $users->get();
        $wallets = DB::table("uangku.payments")
                    ->join("uangku.wallets","payments.id","=","wallets.payment_id")
                    ->join("uangku.payment_types","payments.payment_type_id","=","payment_types.id")
                    ->leftJoin("uangku.users","payments.user_id","=","users.id")
                    ->select("payments.id","wallets.name", "wallets.balance")
                    ->whereIn("payment_types.id",[1,2,3]);

        $categories = DB::table("uangku.expense_categories")
                    ->leftJoin("uangku.users","expense_categories.user_id","=","users.id")
                    ->select("expense_categories.id","expense_categories.name")
                    ->whereNull("expense_categories.user_id");
        if(Auth::user()->user_category_id == 2){
            $wallets = $wallets->where("users.id","=",Auth::user()->id);
            $categories = $categories->orWhere("users.id","=",Auth::user()->id);
        }

        $wallets = $wallets->get();
        $categories = $categories->get();
        $credit_cards = DB::table("uangku.debts")
            ->join("uangku.credit_cards", "debts.id", "=", "credit_cards.debt_id")
            ->join("uangku.payments", "debts.payment_id", "=", "payments.id")
            ->select("payments.id", "debts.name", "debts.remaining_amount", "payments.id as wallet_id")
            ->where("debts.is_active", 1)->get();

        return view('expenses.create', compact('wallets', 'users', 'credit_cards', 'categories'));
    }

    public function store(Request $request): RedirectResponse|View
    {
        $validated = $request->validate([
            'payment_source'        => 'required|string',
            'expense_category'      => 'required|exists:expense_categories,id',
            'expense_title'         => 'required|string|max:100',
            'expense_amount'        => 'required|numeric|min:1',
            'expense_date'          => 'required|date|date_format:Y-m-d',
            'expense_description'   => 'nullable|string',
        ]);

        try {
            [$type, $id] = explode(':', $request->payment_source);
            // if($type == "wallet")
            // {
            //     $payment = DB::table("uangku.payments")
            //         ->where("payments.id", $id)
            //         ->join("uangku.wallets", "payments.id", "=", "wallets.payment_id")
            //         ->value("wallets.payment_id");
            // }else if($type == "credit_card") {
            //     $payment = DB::table("uangku.debts")
            //         ->where("debts.id", $id)
            //         ->join("uangku.payments", "debts.payment_id", "=", "payments.id")
            //         ->join("uangku.credit_cards", "debts.id", "=", "credit_cards.debt_id")
            //         ->value("debts.payment_id");
            // }
            DB::transaction(function() use ($validated, $type, $id) {
                // Insert into expenses table
                DB::table('uangku.expenses')->insert([
                    'user_id' => Auth::user()->id,
                    'payment_id' => $id,
                    'expense_category_id' => $validated['expense_category'],
                    'expense_title' => $validated['expense_title'],
                    'expense_amount' => $validated['expense_amount'],
                    'expense_date' => $validated['expense_date'],
                    'description' => $validated['expense_description'],
                ]);

                if($type == "wallet") {
                    // Deduct from wallet balance
                    DB::table('uangku.wallets')
                        ->where('payment_id', $id)
                        ->decrement('balance', $validated['expense_amount']);
                } else if ($type == "credit_card") {
                    // Increase the remaining amount on the credit card (debt)
                    DB::table('uangku.debts')
                        ->where('payment_id', $id)
                        ->decrement('remaining_amount', $validated['expense_amount']);
                }
            }, 5); // Retry up to 5 times on deadlock

            return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menambahkan pengeluaran: ' . $e->getMessage()])->withInput();
        }
        
    }
}
