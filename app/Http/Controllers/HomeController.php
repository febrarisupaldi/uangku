<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $months = [];

        // Loop through 6 iterations to generate the last 6 months
        for ($i = 0; $i <= 5; $i++) 
        {
            // Generate the date string for the first day of the month $i months ago
            $date = date('M', strtotime(date('Y-M') . " -$i months"));
            
            // Append the date string to the $months array
            $months[] = $date;
        }
        // $count_users = UserController::get_count_all_users();
        $total_income_six_months = IncomeController::getIncomeForSixMonths();
        $total_moneys = WalletController::get_total_money_of_user();
        $total_debts = DebtController::get_total_debt_of_user();
        $total_receivables = ReceivableController::get_total_receivable_of_user();
        // Logic to retrieve and display home page content
        return view('home', compact('total_moneys', 'total_debts', 'total_receivables', 'months', 'total_income_six_months'));
    }

    public function check(){
        $months = [];

        // Loop through 6 iterations to generate the last 6 months
        for ($i = 0; $i <= 5; $i++) 
        {
            // Generate the date string for the first day of the month $i months ago
            $date = date('M', strtotime(date('Y-M') . " -$i months"));
            
            // Append the date string to the $months array
            $months[] = $date;
        }

        return $months;
    }
}
