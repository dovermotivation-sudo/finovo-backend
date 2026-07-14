<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\ReferralReward;
use App\Models\ReferralSetting;
use App\Services\ReferralService;
use Illuminate\Http\Request;

class AdminReferralController extends Controller
{
    protected $referralService;

    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }

    /**
     * Display referral management dashboard
     */
    public function index(Request $request)
    {
        $stats = $this->referralService->getAdminStats();
        
        $filters = [
            'status' => $request->get('status'),
            'referrer_id' => $request->get('referrer_id'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];
        
        $referrals = $this->referralService->getAllReferrals($filters, 15);
        
        return view('admin.referrals.index', compact('stats', 'referrals', 'filters'));
    }

    /**
     * Display referral settings
     */
    public function settings()
    {
        $settings = ReferralSetting::all()->keyBy('key');
        
        return view('admin.referrals.settings', compact('settings'));
    }

    /**
     * Update referral settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'reward_criteria' => 'required|in:registration,kyc_approved,first_transaction',
            'referrer_reward_amount' => 'required|numeric|min:0',
            'referred_reward_amount' => 'required|numeric|min:0',
            'reward_type' => 'required|in:cash,bonus,discount',
            'referral_enabled' => 'required|boolean',
        ]);

        ReferralSetting::set('reward_criteria', $request->reward_criteria, 'string', 'Criteria for reward');
        ReferralSetting::set('referrer_reward_amount', $request->referrer_reward_amount, 'number', 'Reward amount for referrer');
        ReferralSetting::set('referred_reward_amount', $request->referred_reward_amount, 'number', 'Reward amount for referred user');
        ReferralSetting::set('reward_type', $request->reward_type, 'string', 'Type of reward');
        ReferralSetting::set('referral_enabled', $request->referral_enabled, 'boolean', 'Enable or disable referral system');

        return redirect()->back()->with('success', 'Referral settings updated successfully!');
    }

    /**
     * Display specific referral details
     */
    public function show($id)
    {
        $referral = Referral::with(['referrer', 'referredUser', 'rewards'])->findOrFail($id);
        
        return view('admin.referrals.show', compact('referral'));
    }

    /**
     * Manually process reward for a referral
     */
    public function processReward($id)
    {
        $referral = Referral::findOrFail($id);
        
        try {
            $this->referralService->giveReward($referral);
            
            return redirect()->back()->with('success', 'Reward processed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to process reward: ' . $e->getMessage());
        }
    }

    /**
     * Display all rewards
     */
    public function rewards(Request $request)
    {
        $query = ReferralReward::with(['user', 'referral.referrer', 'referral.referredUser']);
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $rewards = $query->latest()->paginate(15);
        
        return view('admin.referrals.rewards', compact('rewards'));
    }

    /**
     * Credit a pending reward
     */
    public function creditReward($id)
    {
        $reward = ReferralReward::findOrFail($id);
        
        try {
            $this->referralService->creditReward($reward);
            
            return redirect()->back()->with('success', 'Reward credited successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to credit reward: ' . $e->getMessage());
        }
    }

    /**
     * Cancel a pending reward
     */
    public function cancelReward($id)
    {
        $reward = ReferralReward::findOrFail($id);
        
        if ($reward->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending rewards can be cancelled!');
        }
        
        $reward->markAsCancelled();
        
        return redirect()->back()->with('success', 'Reward cancelled successfully!');
    }

    /**
     * Get referral statistics (API)
     */
    public function getStats()
    {
        $stats = $this->referralService->getAdminStats();
        
        return response()->json($stats);
    }

    /**
     * Delete multiple referrals
     */
    public function deleteReferrals(Request $request)
    {
        $request->validate([
            'referrals' => 'required|array',
            'referrals.*' => 'exists:referrals,id',
        ]);

        $deletedCount = 0;
        $referrals = Referral::whereIn('id', $request->referrals)->get();

        foreach ($referrals as $referral) {
            // Delete associated rewards first
            $referral->rewards()->delete();
            
            // Delete the referral
            $referral->delete();
            $deletedCount++;
        }

        return redirect()->route('admin.referrals.index')->with('success', $deletedCount . ' referral(s) deleted successfully.');
    }
}
