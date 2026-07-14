<?php

namespace App\Http\Controllers;

use App\Services\ReferralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    protected $referralService;

    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }

    /**
     * Display user's referral dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Generate referral code if user doesn't have one
        if (!$user->referral_code) {
            $user->update(['referral_code' => \App\Models\User::generateReferralCode()]);
            $user->refresh();
        }
        
        $stats = $this->referralService->getUserReferralStats($user);
        $referrals = $this->referralService->getUserReferrals($user, 10);
        $rewards = $user->referralRewards()->with('referral.referredUser')->latest()->paginate(10);

        return view('referrals.index', compact('stats', 'referrals', 'rewards'));
    }

    /**
     * Get referral link and code
     */
    public function getReferralInfo()
    {
        $user = Auth::user();
        
        return response()->json([
            'referral_code' => $user->referral_code,
            'referral_link' => $user->referral_link,
        ]);
    }

    /**
     * Get user's referral statistics
     */
    public function getStats()
    {
        $user = Auth::user();
        $stats = $this->referralService->getUserReferralStats($user);

        return response()->json($stats);
    }

    /**
     * Get user's referral list
     */
    public function getReferrals(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->get('per_page', 10);
        $referrals = $this->referralService->getUserReferrals($user, $perPage);

        return response()->json($referrals);
    }

    /**
     * Get user's referral rewards
     */
    public function getRewards(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->get('per_page', 10);
        $rewards = $user->referralRewards()
            ->with('referral.referredUser')
            ->latest()
            ->paginate($perPage);

        return response()->json($rewards);
    }
}
