<?php

namespace App\Http\Controllers;

use Brick\Math\BigInteger;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class WalletController extends Controller
{
    public function index(): View
    {
        $wallets = DB::table('uangku.payments')
            ->join("uangku.users","payments.user_id","=","users.id")
            ->join("uangku.payment_types","payments.payment_type_id","=","payment_types.id")
            ->join("uangku.wallets","payments.id","=","wallets.payment_id")
            ->select(
                "payments.id",
                "wallets.name",
                "wallets.balance",
                "payment_types.name as wallet_type_name",
                "users.name as user_name")
            ->whereIn("payment_types.id",[1,2,3]);
            if(Auth::user()->user_category_id == 2){
                $wallets = $wallets->where("users.id","=",Auth::user()->id);
            }
            $wallets = $wallets->get();
        return view('wallets.index', compact('wallets'));
    }

    

    public function create(): View
    {
        $wallet_types = DB::table('uangku.payment_types')
            ->whereIn("id",[1,2,3])
            ->get();
        $users = DB::table('uangku.users');
        if(Auth::user()->user_category_id == 2){
            $users = $users->where("users.id","=",Auth::user()->id);
        }
        $users = $users->get();
        return view('wallets.create', compact('wallet_types', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'wallet_name'       => 'required|string|max:255',
                'wallet_type_id'    => 'required|exists:payment_types,id',
                'wallet_balance'    => 'required|numeric|min:0'
            ]);

            DB::transaction(function() use ($validated) {
                $id = DB::table('uangku.payments')->insertGetId([
                    'payment_type_id' => $validated['wallet_type_id'],
                    'user_id' => Auth::user()->id,
                ]);

                DB::table('uangku.wallets')->insert([
                    'payment_id' => $id,
                    'name' => $validated['wallet_name'],
                    'balance' => $validated['wallet_balance'],
                ]);
            });

            return redirect()->route('wallets.index')->with('success', 'Dompet berhasil dibuat');
        } catch (QueryException $e) {
            return redirect()->route('wallets.index')->with('error', 'Gagal Membuat dompet: ' . $e->getMessage());
        }
    }

    public function delete($id): RedirectResponse
    {
        try {
           DB::table('uangku.payments')
           ->where('id', $id)
           ->update(['is_active' => 0]);

            return redirect()->route('wallets.index')->with('success', 'Dompet berhasil dihapus');
        } catch (QueryException $e) {
            return redirect()->route('wallets.index')->with('error', 'Gagal menghapus dompet: ' . $e->getMessage());
        }
    }

    public static function get_wallets(iterable $id): Collection
    {
        $wallets = DB::table('uangku.payments')
            ->join("uangku.payment_types","payments.payment_type_id","=","payment_types.id")
            ->join("uangku.wallets","payments.id","=","wallets.payment_id")
            ->join("uangku.users","payments.user_id","=","users.id")
            ->select(
                "payments.id",
                "wallets.name",
                "payment_types.name as wallet_type_name",
                "wallets.balance")
            ->whereIn("payment_types.id",$id);
        if(Auth::user()->user_category_id == 2){
            $wallets = $wallets->where("users.id","=",Auth::user()->id);
        }
        $wallets = $wallets->get();
        return $wallets;
    }

    public static function get_wallet_type(iterable $id): Collection
    {
        $wallet_types = DB::table('uangku.payment_types')
            ->whereIn("id", $id)
            ->get();
        return $wallet_types;
    }

    public static function get_total_money_of_user()
    {
        return DB::table('uangku.payments')
            ->where('user_id', Auth::user()->id)
            ->whereIn('payment_type_id', [1, 2, 3])
            ->join('uangku.wallets', 'payments.id', '=', 'wallets.payment_id')
            ->sum('wallets.balance');
    }

    public function admin_fee_index(): View
    {
        $wallets = DB::table('uangku.payments')
            ->join("uangku.users","payments.user_id","=","users.id")
            ->join("uangku.payment_types","payments.payment_type_id","=","payment_types.id")
            ->join("uangku.wallets","payments.id","=","wallets.payment_id")
            ->select(
                "payments.id",
                "wallets.name",
                "wallets.balance",
                "wallets.admin_fee",
                "wallets.nominal_admin_fee",
                "wallets.date_admin_fee",
                "payment_types.name as wallet_type_name",
                "users.name as user_name")
            ->whereIn("payment_types.id",[3]);
            if(Auth::user()->user_category_id == 2){
                $wallets = $wallets->where("users.id","=",Auth::user()->id);
            }
            $wallets = $wallets->get();
        return view('wallets.admin-fee.index', compact('wallets'));
    }

    public function admin_fee_show($id):JsonResponse{
        $wallet = DB::table('uangku.payments')
            ->join("uangku.users","payments.user_id","=","users.id")
            ->join("uangku.payment_types","payments.payment_type_id","=","payment_types.id")
            ->join("uangku.wallets","payments.id","=","wallets.payment_id")
            ->select(
                "payments.id",
                "wallets.name",
                "wallets.balance",
                "wallets.admin_fee",
                "wallets.nominal_admin_fee",
                "wallets.date_admin_fee",
                "payment_types.name as wallet_type_name",
                "users.name as user_name")
            ->whereIn("payment_types.id",[3])
            ->where("payments.id", $id)
            ->first();
        return response()->json($wallet);
    }

    public function admin_fee_create($id): View
    {
        $wallet = DB::table('uangku.payments')
            ->join("uangku.users","payments.user_id","=","users.id")
            ->join("uangku.payment_types","payments.payment_type_id","=","payment_types.id")
            ->join("uangku.wallets","payments.id","=","wallets.payment_id")
            ->select(
                "payments.id",
                "wallets.name",
                "wallets.balance",
                "payment_types.name as wallet_type_name",
                "users.name as user_name")
            ->whereIn("payment_types.id",[3])
            ->where("payments.id", $id)
            ->whereNull("wallets.admin_fee")
            ->first();
        return view('wallets.admin-fee.create', compact('wallet'));
    }

    public function admin_fee_store(Request $request, $id): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'nominal_admin_fee' => 'required|numeric|min:0',
                'date_admin_fee'    => 'required|date_format:d'
            ]);

            $admin_fee = 0;

            if($validated['nominal_admin_fee'] != 0){
                $admin_fee = 1;
            }

            DB::table('uangku.wallets')
                ->where('payment_id', $id)
                ->update([
                    'admin_fee' => $admin_fee,
                    'nominal_admin_fee' => $validated['nominal_admin_fee'],
                    'date_admin_fee' => $validated['date_admin_fee'],
                ]);

            return redirect()->route('wallets.admin_fee.index')->with('success', 'Biaya Admin berhasil ditambahkan');
        } catch (QueryException $e) {
            return redirect()->route('wallets.admin_fee.index')->with('error', 'Gagal Menambahkan Biaya Admin: ' . $e->getMessage());
        }
    }

    public function admin_fee_edit(Request $request, $id): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'nominal_admin_fee' => 'required|numeric|min:0',
                'date_admin_fee'    => 'required|date_format:d'
            ]);

            DB::table('uangku.wallets')
                ->where('payment_id', $id)
                ->update([
                    'nominal_admin_fee' => $validated['nominal_admin_fee'],
                    'date_admin_fee' => $validated['date_admin_fee'],
                ]);

            return redirect()->route('wallets.admin_fee.index')->with('success', 'Biaya Admin berhasil diupdate');
        } catch (QueryException $e) {
            return redirect()->route('wallets.admin_fee.index')->with('error', 'Gagal Mengupdate Biaya Admin: ' . $e->getMessage());
        }
    }
}
