<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display transfers
        return view('transfers.index');
    }

    public function create()
    {
        // Logic to show form for creating a new transfer
        return view('transfers.create');
    }
    
    public function store(Request $request)
    {
        // Logic to store a new transfer
        return redirect()->route('transfers.index')->with('success', 'Transfer created successfully.');
    }
}
