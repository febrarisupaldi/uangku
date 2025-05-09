<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display transfers
        return "Check transfers";
        // return view('transfers.index');
    }

    public function create()
    {
        $wallets = WalletController::get_wallets([1,2,3]);
        $users = UserController::get_users();
        // Logic to show form for creating a new transfer
        return view('transfers.create', compact('wallets', 'users'));
    }
    
    public function store(Request $request)
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
                return redirect()->route('transfers.index')->with('success', 'Transfer created successfully.');
            });
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Transfer failed: ' . $e->getMessage());
        }
    }
}
