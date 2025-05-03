<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WalletsController;

class DebtsController extends Controller
{
    public function index()
    {
        return view('debts.index');
    }

    public function create()
    {
        $users = UsersController::get_users();
        $wallet_types = WalletsController::get_wallet_type([6]);
        return view('debts.create', compact('users', 'wallet_types'));
    }

    public function store(Request $request)
    {
        // Logic to store debt
        return redirect()->route('debts.index');
    }
}
