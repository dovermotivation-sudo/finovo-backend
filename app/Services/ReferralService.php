<?php

namespace App\Services;

use App\Models\User;
use App\Models\Referral;
use App\Models\ReferralReward;
use App\Models\ReferralSetting;
use Illuminate\Support\Facades\DB;

class ReferralService
{
    /**
     * Process a referral when a user registers
     */
    public function processReferral(User $referredUser, string $referralCode)
    {
        // Find the referrer by referral code
        $referrer = User::where('referral_code', $referralCode)->first();
        
        if (!$referrer || $referrer->id === $referredUser->id) {
            return false;
        }

        // Update referred user's referred_by field
        $referredUser->update(['referred_by' => $referrer->id]);

        // Create referral record
        $referral = Referral::create([
            'referrer_id' => $referrer->id,
            'referred_user_id' => $referredUser->id,
            'referral_code' => $referralCode,
            'status' => 'pending',
            'referred_at' => now(),
        ]);

        // Check if reward should be given immediately based on criteria
        $this->checkAndProcessReward($referral);

        return $referral;
    }

    /**
     * Check if referral meets reward criteria and process reward
     */
    public function checkAndProcessReward(Referral $referral)
    {
        $criteria = ReferralSetting::get('reward_criteria', 'kyc_approved');
        $referralEnabled = ReferralSetting::get('referral_enabled', true);

        if (!$referralEnabled) {
            return false;
        }

        $shouldReward = false;

        switch ($criteria) {
            case 'registration':
                $shouldReward = true;
                break;
            
            case 'kyc_approved':
                $shouldReward = $referral->referredUser->hasVerifiedKyc();
                break;
            
            case 'first_transaction':
                // You can add logic here to check if user has made first transaction
                // For now, we'll leave it as false
                $shouldReward = false;
                break;
        }

        if ($shouldReward && $referral->status !== 'rewarded') {
            return $this->giveReward($referral);
        }

        return false;
    }

    /**
     * Give reward to referrer and referred user
     */
    public function giveReward(Referral $referral)
    {
        DB::beginTransaction();
        
        try {
            $referrerAmount = ReferralSetting::get('referrer_reward_amount', 100);
            $referredAmount = ReferralSetting::get('referred_reward_amount', 50);
            $rewardType = ReferralSetting::get('reward_type', 'cash');

            // Mark referral as active if it's pending
            if ($referral->status === 'pending') {
                $referral->markAsActive();
            }

            // Create reward for referrer
            $referrerReward = ReferralReward::create([
                'referral_id' => $referral->id,
                'user_id' => $referral->referrer_id,
                'reward_type' => $rewardType,
                'reward_amount' => $referrerAmount,
                'reward_description' => "Referral reward for referring {$referral->referredUser->name}",
                'status' => 'pending',
            ]);

            // Create reward for referred user
            $referredReward = ReferralReward::create([
                'referral_id' => $referral->id,
                'user_id' => $referral->referred_user_id,
                'reward_type' => $rewardType,
                'reward_amount' => $referredAmount,
                'reward_description' => "Welcome bonus for joining via referral",
                'status' => 'pending',
            ]);

            // Auto-credit rewards (you can modify this to require admin approval)
            $this->creditReward($referrerReward);
            $this->creditReward($referredReward);

            // Mark referral as rewarded
            $referral->markAsRewarded();

            DB::commit();
            
            return [
                'referrer_reward' => $referrerReward,
                'referred_reward' => $referredReward,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Credit a reward to user
     */
    public function creditReward(ReferralReward $reward)
    {
        // Mark reward as credited
        $reward->markAsCredited();

        // Here you can add logic to actually credit the amount to user's wallet/account
        // For example:
        // $reward->user->wallet->credit($reward->reward_amount);
        
        return true;
    }

    /**
     * Get referral statistics for a user
     */
    public function getUserReferralStats(User $user)
    {
        return [
            'total_referrals' => $user->referrals()->count(),
            'pending_referrals' => $user->referrals()->pending()->count(),
            'active_referrals' => $user->referrals()->active()->count(),
            'rewarded_referrals' => $user->referrals()->rewarded()->count(),
            'total_earnings' => $user->referralRewards()->credited()->sum('reward_amount'),
            'pending_rewards' => $user->referralRewards()->pending()->sum('reward_amount'),
            'referral_code' => $user->referral_code,
            'referral_link' => $user->referral_link,
        ];
    }

    /**
     * Get referral list for a user
     */
    public function getUserReferrals(User $user, $perPage = 10)
    {
        return $user->referrals()
            ->with(['referredUser', 'rewards'])
            ->latest('referred_at')
            ->paginate($perPage);
    }

    /**
     * Get all referrals for admin (with filters)
     */
    public function getAllReferrals($filters = [], $perPage = 15)
    {
        $query = Referral::with(['referrer', 'referredUser', 'rewards']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['referrer_id'])) {
            $query->where('referrer_id', $filters['referrer_id']);
        }

        if (isset($filters['date_from'])) {
            $query->whereDate('referred_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->whereDate('referred_at', '<=', $filters['date_to']);
        }

        return $query->latest('referred_at')->paginate($perPage);
    }

    /**
     * Get referral statistics for admin dashboard
     */
    public function getAdminStats()
    {
        return [
            'total_referrals' => Referral::count(),
            'pending_referrals' => Referral::pending()->count(),
            'active_referrals' => Referral::active()->count(),
            'rewarded_referrals' => Referral::rewarded()->count(),
            'total_rewards_given' => ReferralReward::credited()->sum('reward_amount'),
            'pending_rewards' => ReferralReward::pending()->sum('reward_amount'),
            'users_with_referrals' => User::whereNotNull('referred_by')->count(),
        ];
    }
}
