<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class VerifyOtpController extends Controller
{
    /**
     * Show the OTP verification form.
     */
    public function show()
    {
        if (!Session::has('otp_user_id')) {
            return redirect()->route('login')->with('error', 'Invalid OTP verification request.');
        }

        return view('auth.verify-otp');
    }

    /**
     * Verify the OTP.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if (!Session::has('otp_user_id')) {
            return redirect()->route('login')->with('error', 'Invalid OTP verification request.');
        }

        $user = User::findOrFail(Session::get('otp_user_id'));
        // Get the most recent OTP for this user
        $otpRecord = Otp::where('user_id', $user->id)
                        ->latest('created_at')
                        ->first();

        if (!$otpRecord || !$otpRecord->validateOtp($request->otp)) {
            return back()->withErrors(['otp' => 'The provided OTP is invalid.']);
        }

        if ($otpRecord->isExpired()) {
            return back()->withErrors(['otp' => 'The OTP has expired. Please request a new one.']);
        }

        // Mark email as verified
        $user->markEmailAsVerified();

        // Delete the OTP record
        $otpRecord->delete();

        // Clear the session
        Session::forget('otp_user_id');

        // Log in the user
        Auth::login($user);

        return redirect()->route('user.dashboard')
            ->with('status', 'Your email has been verified successfully!');
    }

    /**
     * Resend the OTP.
     */
    public function resend()
    {
        if (!Session::has('otp_user_id')) {
            return redirect()->route('login')->with('error', 'Invalid OTP verification request.');
        }

        $user = User::findOrFail(Session::get('otp_user_id'));
        $user->sendOtpNotification();

        return back()->with('status', 'A new OTP has been sent to your email address.');
    }
}
