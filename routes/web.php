<?php

use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ReceivableController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('users.login');
});

Route::get('/login', [UserController::class, 'show_login_form'])
->name('users.show.login');
Route::get('/register', [
    UserController::class,
    'show_register_form'
])->name('users.show.register');
Route::post('/register', [
    UserController::class,
    'register'
])->name('users.register');
Route::post('/login', [
    UserController::class,
    'login'
])->name('users.login');
Route::get('/check', [HomeController::class, 'check']);
Route::get('/income', [IncomeController::class, 'getIncomeForSixMonths']);

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/users/change-password', [
        UserController::class,
        'show_change_password_form'
    ])->name('users.show.change.password');
    Route::post('/users/change-password', [
        UserController::class,
        'change_password'
    ])->name('users.change.password');

    Route::get('/wallets', [
        WalletController::class,
        'index'
    ])->name('wallets.index');
    Route::get('/wallets/create', [
        WalletController::class,
        'create'
    ])->name('wallets.create');
    Route::post('/wallets/store', [
        WalletController::class,
        'store'
    ])->name('wallets.store');

    Route::get('/incomes', [
        IncomeController::class,
        'index'
    ])->name('incomes.index');

    Route::get('/credit-cards', [
        CreditCardController::class,
        'index'
    ])->name('credit.cards.index');

    Route::get('/credit-cards/create', [
        CreditCardController::class,
        'create'
    ])->name('credit.cards.create');

    Route::post('/credit-cards', [
        CreditCardController::class,
        'store'
    ])->name('credit.cards.store');

    Route::get('/debts', [
        DebtController::class,
        'index'
    ])->name('debts.index');

    Route::get('/debts/create', [
        DebtController::class,
        'create'
    ])->name('debts.create');

    Route::post('/debts', [
        DebtController::class,
        'store'
    ])->name('debts.store');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('users.show.login');
    })->name('users.logout');

    Route::get('/receivables', [
        ReceivableController::class,
        'index'
    ])->name('receivables.index');

    Route::get('/receivables/create', [
        ReceivableController::class,
        'create'
    ])->name('receivables.create');

    Route::post('/receivables', [
        ReceivableController::class,
        'store'
    ])->name('receivables.store');

    Route::get('/transfers',[TransferController::class,'index'])->name('transfers.index');
    Route::get('/transfers/create',[TransferController::class,'create'])->name('transfers.create');
    Route::post('/transfers',[TransferController::class,'store'])->name('transfers.store');

    Route::get('/incomes/create', [
        IncomeController::class,
        'create'
    ])->name('incomes.create');
    Route::post('/incomes', [
        IncomeController::class,
        'store'
    ])->name('incomes.store');
});



