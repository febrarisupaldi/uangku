<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
            ->join('uangku.payments', 'incomes.wallet_id', '=', 'payments.id')
            ->join('uangku.wallets', 'payments.id', '=', 'wallets.payment_id')
            ->join('uangku.income_categories', 'incomes.income_category_id', '=', 'income_categories.id')
            ->whereBetween('incomes.transaction_date', [$from, $to])
            ->select('incomes.*', 'wallets.name as wallet_name', 'income_categories.name as category_name')
            ->get();
        return view('incomes.index', compact('incomes', 'from', 'to'));
    }

    public static function getIncomeForSixMonths(){
        $incomeMonths = [];
        for ($i = 0; $i <= 5; $i++) 
        {
            // Generate the date string for the first day of the month $i months ago
            $date = date('M', strtotime(date('Y-M') . " -$i months"));
            $query = DB::table('uangku.incomes')
                ->join('uangku.wallets', 'incomes.wallet_id', '=', 'wallets.payment_id')
                ->join('uangku.income_categories', 'incomes.income_category_id', '=', 'income_categories.id')
                ->where(DB::raw("DATE_FORMAT(incomes.transaction_date,'%b')"), $date)
                ->select(DB::raw('SUM(incomes.income_amount) as total_income'))
                ->first();
            
            // Append the date string to the $months array
            $incomeMonths[] = $query->total_income ?? 0; // Use null coalescing operator to handle null values
        }
        return $incomeMonths;
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
            'wallet_id' => 'required|exists:payments,id',
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
                DB::table('uangku.wallets')
                    ->where('payment_id', $validated['wallet_id'])
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
