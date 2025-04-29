<?php

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




