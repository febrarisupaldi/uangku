<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Http\Controllers\UserController;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;

class CreditCardController extends Controller
{
    public function index(): View
    {
        $credit_cards = DB::table('uangku.credit_cards')
            ->join("uangku.wallets", "credit_cards.wallet_id", "=", "payments.id")
            ->join("uangku.users", "payments.user_id", "=", "users.id")
            ->join("uangku.wallet_types", "payments.wallet_type_id", "=", "wallet_types.id")
            ->select(
                "credit_cards.name",
                "wallet_types.name as wallet_type_name",
                "credit_cards.limit",
                "credit_cards.billing_day",
                "credit_cards.outstanding_balance",
                "credit_cards.is_credit_card",
                DB::raw("if(payments.is_active = 1, 'Aktif', 'Tidak Aktif') as status"),
            );
            if(Auth::user()->user_category_id == 2){
                $credit_cards = $credit_cards->where("users.id","=",Auth::user()->id);
            }
            $credit_cards = $credit_cards->get();
        // Logic to retrieve and display credit cards
        return view('creditcards.index', compact('credit_cards'));
    }

    public function create(): View
    {
        $users = UserController::get_users();
        // Logic to show form for creating a new credit card
        return view('creditcards.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'limit' => 'required|numeric',
            'billing_day' => 'required|numeric|between:1,31',
            'outstanding_balance' => 'required|numeric',
        ]);
        try {
            //code...
            DB::transaction(function() use ($validated) {
                $id = DB::table('uangku.wallets')->insertGetId([
                    'user_id' => $validated['user_id'],
                    'wallet_type_id' => 5, // Assuming 1 is the wallet type for credit cards
                ]);
    
                // Insert into credit_cards table
                DB::table('uangku.credit_cards')->insert([
                    'wallet_id' => $id,
                    'name' => $validated['name'],
                    'limit' => $validated['limit'],
                    'billing_day' => $validated['billing_day'],
                    'outstanding_balance' => $validated['outstanding_balance'],
                ]);
            });
    
            // Logic to store a new credit card
            return redirect()->route('credit.cards.index')->with('success', 'Kartu kredit berhasil ditambahkan');
        } catch (QueryException $e) {
            return redirect()->route('credit.cards.index')->with('error', 'Gagal menambahkan kartu kredit: ' . $e->getMessage());
        }
    }
}
