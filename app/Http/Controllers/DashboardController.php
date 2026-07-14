<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Sample data for dashboard
        $walletData = [
            'USD' => ['balance' => 0.00, 'color' => 'bg-blue-100'],
            'EURO' => ['balance' => 0.00, 'color' => 'bg-green-100'],
            'RUBLE' => ['balance' => 0.00, 'color' => 'bg-yellow-100'],
            'REWARDS' => ['balance' => 0.00, 'color' => 'bg-red-100'],
        ];
        
        $investmentData = [
            'total_invested' => 0,
            'current_value' => 0,
            'profit_loss' => 0,
            'profit_percentage' => 0,
        ];
        
        $portfolioData = [
            'top_performing' => [],
            'recent_transactions' => [],
        ];
        
        return view('dashboard', compact('user', 'walletData', 'investmentData', 'portfolioData'));
    }
    
    public function kyc()
    {
        return view('kyc.application');
    }
    
    public function crypto()
    {
        return view('crypto.index');
    }
    
    public function derivative()
    {
        return view('derivative.index');
    }
    
    public function fixFlex()
    {
        return view('fix-flex.index');
    }
    
    public function compare()
    {
        return view('compare.index');
    }
}
