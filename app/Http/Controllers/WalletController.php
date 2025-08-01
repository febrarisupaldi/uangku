<?php

namespace App\Http\Controllers;

use Brick\Math\BigInteger;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index(): View
    {
        $wallets = DB::table('uangku.wallets')
            ->join("uangku.users","wallets.user_id","=","users.id")
            ->join("uangku.wallet_types","wallets.wallet_type_id","=","wallet_types.id")
            ->join("uangku.wallet_details","wallets.id","=","wallet_details.wallet_id")
            ->select(
                "wallets.id",
                "wallet_details.name",
                "wallet_details.balance",
                "wallet_types.name as wallet_type_name",
                "users.name as user_name")
            ->whereIn("wallet_types.id",[1,2,3]);
            if(Auth::user()->user_category_id == 2){
                $wallets = $wallets->where("users.id","=",Auth::user()->id);
            }
            $wallets = $wallets->get();
        return view('wallets.index', compact('wallets'));
    }

    public function create(): View
    {
        $wallet_types = DB::table('uangku.wallet_types')->whereIn("id",[1,2,3])->get();
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
                'wallet_name' => 'required|string|max:255',
                'wallet_type_id' => 'required|exists:wallet_types,id',
                'user_id' => 'required|exists:users,id',
            ]);

            DB::transaction(function() use ($validated) {
                $id = DB::table('uangku.wallets')->insertGetId([
                    'wallet_type_id' => $validated['wallet_type_id'],
                    'user_id' => $validated['user_id'],
                ]);

                DB::table('uangku.wallet_details')->insert([
                    'name' => $validated['wallet_name'],
                    'wallet_id' => $id,
                ]);
            });

            return redirect()->route('wallets.index')->with('success', 'Dompet berhasil dibuat');
        } catch (QueryException $e) {
            return redirect()->route('wallets.index')->with('error', 'Gagal Membuat dompet: ' . $e->getMessage());
        }
    }

    public static function get_wallets(iterable $id): Collection
    {
        $wallets = DB::table('uangku.wallets')
            ->join("uangku.wallet_types","wallets.wallet_type_id","=","wallet_types.id")
            ->join("uangku.wallet_details","wallets.id","=","wallet_details.wallet_id")
            ->join("uangku.users","wallets.user_id","=","users.id")
            ->select(
                "wallets.id",
                "wallet_details.name",
                "wallet_types.name as wallet_type_name",
                "wallet_details.balance")
            ->whereIn("wallet_types.id",$id);
        if(Auth::user()->user_category_id == 2){
            $wallets = $wallets->where("users.id","=",Auth::user()->id);
        }
        $wallets = $wallets->get();
        return $wallets;
    }

    public static function get_wallet_type(iterable $id): Collection
    {
        $wallet_types = DB::table('uangku.wallet_types')
            ->whereIn("id", $id)
            ->get();
        return $wallet_types;
    }

    public static function get_total_money_of_user()
    {
        return DB::table('uangku.wallets')
            ->where('user_id', Auth::user()->id)
            ->whereIn('wallet_type_id', [1, 2, 3])
            ->join('uangku.wallet_details', 'wallets.id', '=', 'wallet_details.wallet_id')
            ->sum('wallet_details.balance');
    }
}
