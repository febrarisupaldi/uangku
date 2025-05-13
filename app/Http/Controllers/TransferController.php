<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransferController extends Controller
{
    public function index(Request $request): View
    {
        $from = $request->input('from', date("Y-m-01"));
        $to = $request->input('to', date("Y-m-d"));

        // Logic to retrieve and display transfers
        $transfers = DB::table('uangku.transfers')
            ->join('uangku.wallet_details as from_wallet', 'transfers.from_wallet_id', '=', 'from_wallet.wallet_id')
            ->join('uangku.wallet_details as to_wallet', 'transfers.to_wallet_id', '=', 'to_wallet.wallet_id')
            ->whereBetween('transfers.transfer_date', [$from, $to])
            ->select('transfers.*', 'from_wallet.name as from_wallet_name', 'to_wallet.name as to_wallet_name')
            ->get();
        return view('transfers.index', compact('transfers', 'from', 'to'));
    }

    public function create(): View
    {
        $wallets = WalletController::get_wallets([1,2,3]);
        $users = UserController::get_users();
        // Logic to show form for creating a new transfer
        return view('transfers.create', compact('wallets', 'users'));
    }
    
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'from_wallet_id' => 'required|exists:wallets,id',
            'to_wallet_id' => 'required|exists:wallets,id',
            'transfer_amount' => 'required|numeric|min:0',
            'transfer_date' => 'required|date|date_format:Y-m-d',
            'description' => 'nullable|string',
        ]);

        try {
            DB::transaction(function() use ($validated) {
                // Logic to handle the transfer transaction
                DB::table('uangku.wallet_details')
                    ->where('wallet_id', $validated['from_wallet_id'])
                    ->decrement('balance', $validated['transfer_amount']);
                DB::table('uangku.wallet_details')
                    ->where('wallet_id', $validated['to_wallet_id'])
                    ->increment('balance', $validated['transfer_amount']);
                DB::table('uangku.transfers')->insert([
                    'from_wallet_id' => $validated['from_wallet_id'],
                    'to_wallet_id' => $validated['to_wallet_id'],
                    'transfer_amount' => $validated['transfer_amount'],
                    'transfer_date' => $validated['transfer_date'],
                    'description' => $validated['description'],
                ]);
        // Logic to store a new transfer 
            });
            return redirect()->route('transfers.index')->with('success', 'Transfer created successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Transfer failed: ' . $e->getMessage());
        }
    }
}
