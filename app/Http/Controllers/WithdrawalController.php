<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    /**
     * Show withdrawal request form and history.
     */
    public function index()
    {
        $user = Auth::user();

        // Fetch user's previous withdrawal requests
        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('withdrawals.index', compact('withdrawals'));
    }

    /**
     * Store a new withdrawal request.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'network' => 'required|in:BEP20,TRC20',
            'wallet_address' => 'required|string|max:255',
        ]);

        $fee = 1.00;
        $totalDeduction = $request->amount + $fee;

        if ($user->portfolio_value < $totalDeduction) {
            return back()->withInput()->with('error', 'Insufficient portfolio balance to process this withdrawal (including $1.00 fee).');
        }

        DB::transaction(function () use ($user, $request, $fee, $totalDeduction) {
            // Deduct from user's portfolio immediately
            $user->portfolio_value -= $totalDeduction;
            $user->save();

            // Create withdrawal request
            Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'fee' => $fee,
                'network' => $request->network,
                'wallet_address' => $request->wallet_address,
                'status' => 'pending'
            ]);
        });

        return redirect()->route('withdrawals.index')->with('success', 'Withdrawal request submitted successfully! Admin will verify and process it shortly.');
    }
}
