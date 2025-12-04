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
            ->join("uangku.payments", "debts.payment_id", "=", "payments.id")
            ->join("uangku.users", "payments.user_id", "=", "users.id")
            ->join("uangku.payment_types", "payments.payment_type_id", "=", "payment_types.id")
            ->join("uangku.debt_statuses", "debts.debt_status_id", "=", "debt_statuses.id")
            ->select(
                "debts.id",
                "debts.name",
                "debts.total_amount",
                "debts.remaining_amount",
                "debts.start_date",
                "debts.description",
                "payment_types.name as wallet_type_name",
                "users.name as user_name",
                "debt_statuses.name as status_name",
            )
            ->where("payment_types.id", 6); // Assuming 6 is the wallet type for debts
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
            'debt_name'         => 'required|string|max:255',
            'debt_amount'       => 'required|numeric|min:0',
            'start_date'        => 'required|date|date_format:Y-m-d',
            'description'       => 'nullable|string',
            'is_credit_card'    => 'nullable|boolean',
        ]);

        try {
            DB::transaction(function() use ($validated) {
                $id = DB::table('uangku.payments')
                        ->insertGetId([
                            'user_id'           => Auth::user()->id,
                            'payment_type_id'   => 6, // Assuming 6 is the wallet type for debts
                        ]);

                $id = DB::table('uangku.debts')->insertGetId([
                    'payment_id'         => $id,
                    'name'              => $validated['debt_name'],
                    'total_amount'      => $validated['debt_amount'],
                    'remaining_amount'  => $validated['debt_amount'],
                    'start_date'        => $validated['start_date'],
                    'description'       => $validated['description'],
                ]);

                if($validated['is_credit_card'] == 1) {
                    DB::table('uangku.credit_cards')->insert([
                        'debt_id' => $id,
                        'billing_day' => date('d', strtotime($validated['start_date'])),
                    ]);
                }
            });
            return redirect()->route('debts.index')->with('success', 'Hutang berhasil dibuat.');
        } catch (QueryException $e) {
            return redirect()->route('debts.index')->with('error', 'Hutang gagal dibuat.');
        }
    }

    public function debt_payment_index(): View
    {
        $debts = DB::table("uangku.debt_payments")
            ->join("uangku.debts", "debt_payments.debt_id", "=", "debts.id")
            ->join("uangku.wallets", "debt_payments.wallet_id", "=", "wallets.id")
            ->select(
                "debt_payments.id",
                "debt_payments.title",
                "debt_payments.payment_date",
                "debt_payments.amount_paid",
                "debts.name as debt_name",
                "wallets.name as wallet_name"
            )->get();

        return view('debts.payments.index', compact('debts'));
    }

    public function debt_payment_create(): View
    {
        $debts = DB::table('uangku.debts')
            ->where('debt_status_id', 'A') // Assuming 'A' is the status for active debts
            ->join('uangku.payments', 'payments.id', '=', 'debts.payment_id')
            ->select('debts.id', 'debts.name', 'debts.remaining_amount', 'payments.id as payment_id')
            ->get();

        $wallets = DB::table('uangku.wallets')
            ->join('uangku.payments', 'payments.id', '=', 'wallets.payment_id')
            ->select('wallets.id', 'wallets.name', 'wallets.balance')
            ->get();

        return view('debts.payments.create', compact('debts', 'wallets'));
    }

    public static function get_total_debt_of_user(){
        return DB::table('uangku.debts')
            ->where(['user_id' => Auth::user()->id, 'payment_type_id' => 6])
            ->whereIn('debt_status_id', ['A','P']) // Assuming 1 is the status for active debts
            ->join('uangku.payments', 'payments.id', '=', 'debts.payment_id')
            ->sum('debts.remaining_amount');
    }

}
