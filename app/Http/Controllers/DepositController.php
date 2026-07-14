<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\DepositSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    /**
     * Show deposit request and verification form.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Fetch network configurations
        $settings = [
            'bep20_address' => DepositSetting::getValue('bep20_address'),
            'bep20_qr_code' => DepositSetting::getValue('bep20_qr_code'),
            'trc20_address' => DepositSetting::getValue('trc20_address'),
            'trc20_qr_code' => DepositSetting::getValue('trc20_qr_code'),
        ];

        // Fetch user's previous deposit requests
        $deposits = Deposit::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('deposits.index', compact('settings', 'deposits'));
    }

    /**
     * Store a new deposit request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'network' => 'required|in:BEP20,TRC20',
            'transaction_id' => 'required|string|max:255|unique:deposits,transaction_id',
            'screenshot' => 'required|image|mimes:jpg,jpeg,png|max:5120', // Max 5MB
        ], [
            'transaction_id.unique' => 'This Transaction ID has already been submitted.',
            'screenshot.max' => 'The screenshot size must not exceed 5MB.',
        ]);

        // Save screenshot to public storage
        $screenshotPath = $request->file('screenshot')->store('deposit_screenshots', 'public');

        // Create deposit request
        Deposit::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'network' => $request->network,
            'transaction_id' => $request->transaction_id,
            'screenshot_path' => $screenshotPath,
            'status' => 'pending'
        ]);

        return redirect()->route('deposits.index')->with('success', 'Deposit request submitted successfully! Admin will verify and approve it shortly.');
    }
}
