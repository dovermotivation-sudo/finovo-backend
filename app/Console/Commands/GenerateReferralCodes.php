<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateReferralCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'referrals:generate-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate referral codes for users who don\'t have one';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating referral codes for users without codes...');
        
        $users = User::whereNull('referral_code')->get();
        $count = 0;
        
        foreach ($users as $user) {
            $user->update(['referral_code' => User::generateReferralCode()]);
            $count++;
        }
        
        $this->info("Generated {$count} referral codes successfully!");
        
        return Command::SUCCESS;
    }
}
