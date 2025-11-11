<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionsController extends Controller
{
    public function index(Request $request): View
    {
        $from = $request->input('from', date("Y-m-01"));
        $to = $request->input('to', date("Y-m-d"));
        $subscriptions = DB::table("uangku.subscriptions")
                        ->whereBetween("subscriptions.subscription_date", [$from, $to])
                        ->join("uangku.credit_cards","subscriptions.credit_card_id","=","credit_cards.id")
                        ->join("uangku.debts","credit_cards.debt_id","=","debts.id")
                        ->join("uangku.expense_categories","subscriptions.expense_category_id","=","expense_categories.id")
                        ->join("uangku.subscription_types","subscriptions.subscription_type_id","=","subscription_types.id")
                        ->leftJoin("uangku.users","subscriptions.user_id","=","users.id")
                        ->select("subscriptions.*","debts.name as credit_card_name","expense_categories.name as category_name","subscription_types.name as subscription_type_name")
                        ->get();
        return view('subscriptions.index', compact('subscriptions'));
    }

    public function create(): View
    {
        $wallets = DB::table("uangku.payments")
                    ->where("payments.is_active",1)
                    ->join("uangku.debts","payments.id","=","debts.payment_id")
                    ->join("uangku.credit_cards","debts.id","=","credit_cards.debt_id")
                    ->leftJoin("uangku.users","payments.user_id","=","users.id")
                    ->select("debts.id","debts.name", "debts.remaining_amount");

        $categories = DB::table("uangku.expense_categories")
                    ->leftJoin("uangku.users","expense_categories.user_id","=","users.id")
                    ->select("expense_categories.id","expense_categories.name")
                    ->whereNull("expense_categories.user_id");
        if(Auth::user()->user_category_id == 2){
            $wallets = $wallets->where("users.id","=",Auth::user()->id);
            $categories = $categories->orWhere("users.id","=",Auth::user()->id);
        }
        $subs_types = DB::table("uangku.subscription_types")
                    ->select("subscription_types.id","subscription_types.name")
                    ->get();

        $kind_subs = DB::table("uangku.subscription_types")->get();

        $wallets = $wallets->get();
        $categories = $categories->get();
        $credit_cards = DB::table("uangku.debts")
            ->join("uangku.credit_cards", "debts.id", "=", "credit_cards.debt_id")
            ->join("uangku.payments", "debts.payment_id", "=", "payments.id")
            ->select("credit_cards.id", "debts.name", "debts.remaining_amount")
            ->where("debts.is_active", 1)->get();
        return view('subscriptions.create', compact('wallets', 'categories', 'credit_cards', 'subs_types', 'kind_subs'));
    }

    public function history($id): JsonResponse
    {
        $history = DB::table("uangku.subscription_expenses")
                    ->join("uangku.expenses","subscription_expenses.expense_id","=","expenses.id")
                    ->select("expenses.*")
                    ->where("subscription_expenses.subscription_id",$id)
                    ->get();

        return response()->json($history);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'credit_card'            => 'required|exists:credit_cards,id',
            'expense_category'  => 'required|exists:expense_categories,id',
            'subscription_type' => 'required|exists:subscription_types,id',
            'subscriptions_description'=> 'required|string|max:255',
            'subscription_amount'  => 'required|numeric|min:0',
            'subscription_date'           => 'required|date|date_format:Y-m-d',
            'description'          => 'nullable|string',    
        ]);
        
        try {
            //code...
            DB::transaction(function() use ($validated) {
                $id_subs = DB::table('uangku.subscriptions')->insertGetId([
                    'credit_card_id'      => $validated['credit_card'],
                    'expense_category_id'  => $validated['expense_category'],
                    'subscription_type_id' => $validated['subscription_type'],
                    'user_id'              => Auth::user()->id,
                    'subscription_description' => $validated['subscriptions_description'] ?? null,
                    'amount'               => $validated['subscription_amount'],
                    'subscription_date'           => $validated['subscription_date'],
                    'subscription_day'    => date("d", strtotime($validated['subscription_date'])),
                    'subscription_month'  => date("m", strtotime($validated['subscription_date']))
                ]);

                if(date("d-m") == date("d-m", strtotime($validated['subscription_date'])))
                {
                        // Insert into expenses as well
                    $id_expense = DB::table('uangku.expenses')->insertGetId([
                        'payment_id'      => $validated['credit_card'],
                        'expense_category_id' => $validated['expense_category'],
                        'expense_title'       => 'Subscription: ' . $validated['subscriptions_description'],
                        'description'         => $validated['subscriptions_description'],
                        'user_id'             => Auth::user()->id,
                        'expense_amount'      => $validated['subscription_amount'],
                        'expense_date'        => $validated['subscription_date'],
                        'description'         => $validated['subscriptions_description']
                    ]);

                    DB::table('uangku.subscription_expenses')->insert([
                        'subscription_id' => $id_subs,
                        'expense_id'      => $id_expense
                    ]);

                    // Update wallet balance
                    DB::table('uangku.credit_cards')->where('credit_cards.id', $validated['credit_card'])
                        ->leftJoin("uangku.debts","credit_cards.debt_id","=","debts.id")
                        ->decrement('debts.remaining_amount', $validated['subscription_amount']);
                }
            }, 3);
            return redirect()->route('subscriptions.index')->with('success', 'Subscription created');
        } catch (\Exception $e) {
            // Handle exception if needed
            Log::error('Failed to create subscription: ' . $e->getMessage());
            return redirect()->route('subscriptions.index')->with('error', 'Failed to create subscription.');
        }

        
    }
}
