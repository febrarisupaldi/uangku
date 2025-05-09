<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display incomes        
        return "Check incomes";
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
