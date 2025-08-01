<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DebtController extends Controller
{
    public function index(): View
    {
        $debts = DB::table('uangku.debts')
            ->join("uangku.wallets", "debts.wallet_id", "=", "wallets.id")
            ->join("uangku.users", "wallets.user_id", "=", "users.id")
            ->join("uangku.wallet_types", "wallets.wallet_type_id", "=", "wallet_types.id")
            ->join("uangku.debt_statuses", "debts.debt_status_id", "=", "debt_statuses.id")
            ->select(
                "debts.id",
                "debts.name",
                "debts.total_amount",
                "debts.remaining_amount",
                "debts.start_date",
                "debts.description",
                "wallet_types.name as wallet_type_name",
                "users.name as user_name",
                "debt_statuses.name as status_name",
            )
            ->where("wallet_types.id", 6); // Assuming 6 is the wallet type for debts
        if (Auth::user()->user_category_id == 2) {
            $debts = $debts->where("users.id", "=", Auth::user()->id);
        }
        $debts = $debts->get();
        return view('debts.index', compact('debts'));
    }

    public function create(): View
    {
        $users = UserController::get_users();
        $wallet_types = WalletController::get_wallet_type([6]);
        return view('debts.create', compact('users', 'wallet_types'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'wallet_type_id'    => 'required|numeric|in:6',
            'debt_name'         => 'required|string|max:255',
            'debt_amount'       => 'required|numeric|min:0',
            'start_date'        => 'required|date|date_format:Y-m-d',
            'description'       => 'nullable|string',
        ]);

        try {
            DB::transaction(function() use ($validated) {
                $id = DB::table('uangku.wallets')
                        ->insertGetId([
                            'user_id'           => $validated['user_id'],
                            'wallet_type_id'    => $validated['wallet_type_id'], // Assuming 6 is the wallet type for debts
                        ]);

                DB::table('uangku.debts')->insert([
                    'wallet_id'         => $id,
                    'name'              => $validated['debt_name'],
                    'total_amount'      => $validated['debt_amount'],
                    'remaining_amount'  => $validated['debt_amount'],
                    'start_date'        => $validated['start_date'],
                    'description'       => $validated['description'],
                ]);
            });
            return redirect()->route('debts.index')->with('success', 'Hutang berhasil dibuat.');
        } catch (QueryException $e) {
            return redirect()->route('debts.index')->with('error', 'Hutang gagal dibuat.');
        }
    }

    public static function get_total_debt_of_user(){
        return DB::table('uangku.debts')
            ->where(['user_id' => Auth::user()->id, 'wallet_type_id' => 6])
            ->whereIn('debt_status_id', ['A','P']) // Assuming 1 is the status for active debts
            ->join('uangku.wallets', 'wallets.id', '=', 'debts.wallet_id')
            ->sum('debts.remaining_amount');
    }

}
