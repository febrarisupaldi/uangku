<?php

use App\Http\Controllers\CreditCardsController;
use App\Http\Controllers\DebtsController;
use App\Http\Controllers\IncomesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WalletsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('users.login');
});

Route::get('/login', [UsersController::class, 'show_login_form'])
->name('users.show.login');
Route::get('/register', [
    UsersController::class,
    'show_register_form'
])->name('users.show.register');
Route::post('/register', [
    UsersController::class,
    'register'
])->name('users.register');
Route::post('/login', [
    UsersController::class,
    'login'
])->name('users.login');

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/wallets', [
        WalletsController::class,
        'index'
    ])->name('wallets.index');
    Route::get('/wallets/create', [
        WalletsController::class,
        'create'
    ])->name('wallets.create');
    Route::post('/wallets/store', [
        WalletsController::class,
        'store'
    ])->name('wallets.store');

    Route::get('/incomes', [
        IncomesController::class,
        'index'
    ])->name('incomes.index');

    Route::get('/credit-cards', [
        CreditCardsController::class,
        'index'
    ])->name('credit.cards.index');

    Route::get('/credit-cards/create', [
        CreditCardsController::class,
        'create'
    ])->name('credit.cards.create');

    Route::post('/credit-cards', [
        CreditCardsController::class,
        'store'
    ])->name('credit.cards.store');

    Route::get('/debts', [
        DebtsController::class,
        'index'
    ])->name('debts.index');

    Route::get('/debts/create', [
        DebtsController::class,
        'create'
    ])->name('debts.create');

    Route::post('/debts', [
        DebtsController::class,
        'store'
    ])->name('debts.store');
});



