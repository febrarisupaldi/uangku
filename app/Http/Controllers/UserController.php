<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function show_login_form(): View|RedirectResponse{
        if (Auth::check()) {
            return redirect('home'); // atau route dashboard kamu
        }
        return view('login');
    }

    public function show_register_form(): View|RedirectResponse{
        if (Auth::check()) {
            return redirect('home'); // atau route dashboard kamu
        }
        return view('register');
    }

    public function register(Request $request): RedirectResponse{
        $validated = $request->validate([
            'username' => 'required|unique:users,email',
            'fullname' => 'required|string|max:255',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        try {
            //code...
            DB::table('uangku.users')->insert([
                'email' => $validated['username'],
                'name' => $validated['fullname'],
                'email_verified_at' => now(),
                'password' => Hash::driver('argon')->make($validated['password'])
            ]);

            return redirect()->route('users.show.login')->with('success', 'Berhasil daftar, Silahkan login untuk melanjutkan');
        } catch (QueryException $e) {
            return redirect()->route('users.show.register')->with('error', 'Failed to register user: ' . $e->getMessage());
            //throw $th;
        }

        // Logic to register user
        // If successful, redirect to login
        return redirect()->route('users.show.login');
    }

    public function login(Request $request): RedirectResponse{
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt(['email' => $validated['username'], 'password' => $validated['password']])) {
            return redirect()->route('home')->with('success', 'Login successful');
        } else {
            return redirect()->route('users.show.login')->with('error', 'Invalid credentials');
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('users.show.login')->with('success', 'Logout successful');
    }

    public static function get_users(): Collection{
        $users = DB::table('uangku.users');
        if(Auth::user()->user_category_id == 2){
            $users = $users->where("users.id","=",Auth::user()->id);
        }
        $users = $users->get();
        return $users;
    }

    public function show_change_password_form(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('users.show.login')->with('error', 'You must be logged in to change your password');
        }
        return view('change_password');
    }

    public function change_password(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Auth::check()) {
            return redirect()->route('users.show.login')->with('error', 'You must be logged in to change your password');
        }

        $user = Auth::user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect');
        }

        try {
            $password = Hash::make($validated['new_password']);

            return redirect()->route('home')->with('success', 'Password changed successfully');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Failed to change password: ' . $e->getMessage());
        }
    }

    public static function get_count_all_users(): int
    {
        return DB::table('uangku.users')->where('user_category_id', 2)->count();
    }
}
