<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReceivableController extends Controller
{
    public function index(): View
    {
        $receivables = DB::table('uangku.receivables')
            ->join("uangku.payments", "receivables.payment_id", "=", "payments.id")
            ->join("uangku.users", "payments.user_id", "=", "users.id")
            ->join("uangku.payment_types", "payments.payment_type_id", "=", "payment_types.id")
            ->join("uangku.receivable_statuses", "receivables.receivable_status_id", "=", "receivable_statuses.id")
            ->select(
                "receivables.id",
                "receivables.name",
                "receivables.total_amount",
                "receivables.remaining_amount",
                "receivables.start_date",
                "receivables.description",
                "payment_types.name as wallet_type_name",
                "users.name as user_name",
                "receivable_statuses.name as status_name"
            )
            ->where("payment_types.id", 7); // Assuming 7 is the payment type for receivables
        if (Auth::user()->user_category_id == 2) {
            $receivables = $receivables->where("users.id", "=", Auth::user()->id);
        }
        $receivables = $receivables->get();
        // Logic to retrieve and display receivables
        return view('receivables.index', compact('receivables'));
    }
    public function create()
    {
        $users = UserController::get_users();
        $wallet_types = WalletController::get_wallet_type([7]);
        // Logic to show form for creating a new receivable
        return view('receivables.create', compact('users', 'wallet_types'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receivable_name'   => 'required|string|max:255',
            'receivable_amount' => 'required|numeric|min:0',
            'start_date'        => 'required|date|date_format:Y-m-d',
            'is_credit_card'    => 'boolean',
            'description'       => 'nullable|string',
        ]);

        try {
            DB::transaction(function() use ($validated) {
                $id = DB::table('uangku.payments')
                        ->insertGetId([
                            'user_id'           => Auth::user()->id,
                            'payment_type_id'    => 7, // Assuming 7 is the wallet type for receivables
                        ]);

                DB::table('uangku.receivables')->insert([
                    'payment_id'         => $id,
                    'name'              => $validated['receivable_name'],
                    'total_amount'      => $validated['receivable_amount'],
                    'remaining_amount'  => $validated['receivable_amount'],
                    'start_date'        => $validated['start_date'],
                    'description'       => $validated['description'],
                ]);
            });
            return redirect()->route('receivables.index')->with('success', 'Piutang berhasil dibuat.');
        } catch (QueryException $e) {
            return redirect()->route('receivables.index')->with('error', 'Piutang gagal dibuat.');
        }
    }

    public static function get_total_receivable_of_user(){
        return DB::table('uangku.receivables')
            ->where(['user_id' => Auth::user()->id, 'payment_type_id' => 7])
            ->whereIn('receivable_status_id', ['A','P']) // Assuming 1 is the status for active receivables
            ->join('uangku.payments', 'payments.id', '=', 'receivables.payment_id')
            ->sum('receivables.remaining_amount');
    }
}
