<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index(Request $request){
        $from = $request->input('from', date("Y-m-01"));
        $to = $request->input('to', date("Y-m-d"));

        $expenses = DB::table("uangku.expenses" , "e")
            ->where("e.user_id", "=", Auth::user()->id)
            ->whereBetween("e.expense_date", [$from, $to])
            ->join("uangku.users as u", "e.user_id", "=", "u.id")
            ->leftJoin("uangku.wallets as w", "e.payment_id", "=", "w.id")
            ->leftJoin("uangku.wallet_details as wd", "w.id", "=", "wd.wallet_id")
            ->leftJoin("uangku.debts as d", "e.payment_id", "=", "d.id")
            ->select("e.*", "u.name as user_name", "wd.name as wallet_name", "d.name as credit_card_name")
            ->get();
        return view('expenses.index', compact('expenses', 'from', 'to'));
    }

    public function create(){
        $users = DB::table('uangku.users');
        if(Auth::user()->user_category_id == 2){
            $users = $users->where("users.id","=",Auth::user()->id);
        }
        $users = $users->get();
        $wallets = DB::table("uangku.wallets")
                    ->join("uangku.wallet_details","wallets.id","=","wallet_details.wallet_id")
                    ->join("uangku.wallet_types","wallets.wallet_type_id","=","wallet_types.id")
                    ->leftJoin("uangku.users","wallets.user_id","=","users.id")
                    ->select("wallets.id","wallet_details.name", "wallet_details.balance")
                    ->whereIn("wallet_types.id",[1,2,3]);

        $categories = DB::table("uangku.expense_categories")
                    ->leftJoin("uangku.users","expense_categories.user_id","=","users.id")
                    ->select("expense_categories.id","expense_categories.name");
        if(Auth::user()->user_category_id == 2){
            $wallets = $wallets->where("users.id","=",Auth::user()->id);
            $categories = $categories->where("users.id","=",Auth::user()->id);
        }

        $wallets = $wallets->get();
        $categories = $categories->get();
        $credit_cards = DB::table("uangku.debts")->where("is_credit_card", 1)->get();

        return view('expenses.create', compact('wallets', 'users', 'credit_cards', 'categories'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'payment_source'        => 'required|string',
            'expense_category'      => 'required|exists:uangku.expense_categories,id',
            'expense_title'         => 'required|string|max:100',
            'expense_amount'        => 'required|numeric|min:1',
            'expense_date'          => 'required|date|date_format:Y-m-d',
            'expense_description'   => 'nullable|string',
        ]);

        try {
            [$type, $id] = explode(':', $request->payment_source);
            if($type == "wallet") 
            $payment = DB::table("uangku.wallets")->where("id", $id)->value("wallet_id");
            else if($type == "credit_card") $payment = DB::table("uangku.debts")->where("id", $id)->value("wallet_id");

            DB::transaction(function() use ($validated, $payment, $type, $id) {
                // Insert into expenses table
                DB::table('uangku.expenses')->insert([
                    'user_id' => Auth::user()->id,
                    'payment_id' => $payment,
                    'expense_category_id' => $validated['expense_category'],
                    'expense_title' => $validated['expense_title'],
                    'expense_amount' => $validated['expense_amount'] ?? null,
                    'expense_date' => $validated['expense_date'],
                    'expense_description' => $validated['expense_description'] ?? null,
                ]);

                if($type == "wallet") {
                    // Deduct from wallet balance
                    DB::table('uangku.wallet_details')
                        ->where('wallet_id', $id)
                        ->decrement('balance', $validated['expense_amount']);
                } else if ($type == "credit_card") {
                    // Increase the remaining amount on the credit card (debt)
                    DB::table('uangku.debts')
                        ->where('id', $id)
                        ->increment('remaining_amount', $validated['expense_amount']);
                }
            });

            return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menambahkan pengeluaran: ' . $e->getMessage()])->withInput();
        }
        
    }
}
