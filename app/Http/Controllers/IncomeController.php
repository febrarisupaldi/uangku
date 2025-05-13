<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IncomeController extends Controller
{
    public function index(Request $request): View
    {
        // Logic to retrieve and display incomes        
        $from = $request->input('from', date("Y-m-01"));
        $to = $request->input('to', date("Y-m-d"));

        $incomes = DB::table('uangku.incomes')
            ->join('uangku.wallet_details', 'incomes.wallet_id', '=', 'wallet_details.wallet_id')
            ->join('uangku.income_categories', 'incomes.income_category_id', '=', 'income_categories.id')
            ->whereBetween('incomes.transaction_date', [$from, $to])
            ->select('incomes.*', 'wallet_details.name as wallet_name', 'income_categories.name as category_name')
            ->get();
        return view('incomes.index', compact('incomes', 'from', 'to'));
    }

    public function create()
    {
        $income_categories = DB::table('uangku.income_categories')
            ->select('id', 'name')
            ->get();
        $users = UserController::get_users();
        $wallets = WalletController::get_wallets([1,2,3]);
        // Logic to show form for creating a new income
        return view('incomes.create', compact('income_categories', 'users', 'wallets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'wallet_id' => 'required|exists:wallets,id',
            'income_category_id' => 'required|exists:income_categories,id',
            'income_amount' => 'required|numeric',
            'description' => 'nullable|string|max:255',
            'income_date' => 'required|date',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                DB::table('uangku.incomes')->insert([
                    'wallet_id' => $validated['wallet_id'],
                    'income_category_id' => $validated['income_category_id'],
                    'income_amount' => $validated['income_amount'],
                    'description' => $validated['description'],
                    'transaction_date' => $validated['income_date'],
                ]);

                // Update the wallet balance
                DB::table('uangku.wallet_details')
                    ->where('wallet_id', $validated['wallet_id'])
                    ->increment('balance', $validated['income_amount']);
            });
            return redirect()->route('incomes.index')->with('success', 'Income created successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to create income.' . $e->getMessage()]);
        }
        // Logic to store a new income
        
    }
}
