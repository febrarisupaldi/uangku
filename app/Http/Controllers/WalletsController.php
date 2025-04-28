<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletsController extends Controller
{
    public function index()
    {
        $wallets = DB::table('uangku.wallets')
            ->join("uangku.users","wallets.user_id","=","users.id")
            ->join("uangku.wallet_types","wallets.wallet_type_id","=","wallet_types.id")
            ->select(
                "wallets.id",
                "wallets.name",
                "wallets.balance",
                "wallet_types.name as wallet_type_name",
                "users.name as user_name")
            ->get();
        // Logic to retrieve and display wallets
        return view('wallets.index', compact('wallets'));
    }

    public function create()
    {
        $wallet_types = DB::table('uangku.wallet_types')->get();
        $users = DB::table('uangku.users')->get();
        return view('wallets.create', compact('wallet_types', 'users'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'wallet_name' => 'required|string|max:255',
                'wallet_type_id' => 'required|exists:wallet_types,id',
                'user_id' => 'required|exists:users,id',
            ]);
    
            DB::table('uangku.wallets')->insert([
                'name' => $validated['wallet_name'],
                'wallet_type_id' => $validated['wallet_type_id'],
                'user_id' => $validated['user_id'],
            ]);
    
            return redirect()->route('wallets.index')->with('success', 'Wallet created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('wallets.index')->with('error', 'Failed create wallet: ' . $e->getMessage());
        }
    }
}
