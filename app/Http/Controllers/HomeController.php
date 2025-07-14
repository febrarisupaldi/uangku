<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $count_users = UserController::get_count_all_users();
        // Logic to retrieve and display home page content
        return view('home', compact('count_users'));
    }
}
