<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Plan;
use Illuminate\Support\Facades\Session;
use App\Services\ReferralService;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $plans = Plan::all(); // Fetch all plans
        $referralCode = $request->get('ref'); // Get referral code from URL
        return view('auth.register', compact('plans', 'referralCode'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_number' => ['required', 'string', 'max:20','regex:/^[0-9\-\+\(\)\s]+$/', 'unique:users,phone_number'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'plan_id' => ['required', 'exists:plans,id'],
            'referral_code' => ['nullable', 'string', 'exists:users,referral_code'],
        ]);

        // Generate unique referral code for new user
        $referralCode = User::generateReferralCode();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'plan_id' => $request->plan_id,
            'role' => 'user',
            'portfolio_value' => 0,
            'growth_rate' => 0,
            'total_returns' => 0,
            'referral_code' => $referralCode,
        ]);

        // Process referral if referral code was provided
        if ($request->filled('referral_code')) {
            $referralService = new ReferralService();
            $referralService->processReferral($user, $request->referral_code);
        }

        // Send OTP to user's email
        $user->sendOtpNotification();

        // Store user ID in session for verification
        Session::put('otp_user_id', $user->id);

        return redirect()->route('verification.notice');
    }
}
