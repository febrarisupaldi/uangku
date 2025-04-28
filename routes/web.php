<?php

use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/home', function () {
    return view('home');
});

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



