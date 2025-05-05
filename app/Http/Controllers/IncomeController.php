<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display incomes        
        return;
    }

    public function create()
    {
        // Logic to show form for creating a new income
        return view('incomes.create');
    }

    public function store(Request $request)
    {
        // Logic to store a new income
        return redirect()->route('incomes.index')->with('success', 'Income created successfully.');
    }
}
