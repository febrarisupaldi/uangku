<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;

class DebtController extends Controller
{
    public function index()
    {
        return view('debts.index');
    }

    public function create()
    {
        $users = UserController::get_users();
        $wallet_types = WalletController::get_wallet_type([6]);
        return view('debts.create', compact('users', 'wallet_types'));
    }

    public function store(Request $request)
    {
        // Logic to store debt
        return redirect()->route('debts.index');
    }
}
