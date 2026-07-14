<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('referral_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->string('type')->default('string'); // string, number, boolean, json
            $table->text('description')->nullable();
            $table->timestamps();
        });
        
        // Insert default settings
        DB::table('referral_settings')->insert([
            [
                'key' => 'reward_criteria',
                'value' => 'kyc_approved',
                'type' => 'string',
                'description' => 'Criteria for reward: registration, kyc_approved, first_transaction',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'referrer_reward_amount',
                'value' => '100',
                'type' => 'number',
                'description' => 'Reward amount for referrer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'referred_reward_amount',
                'value' => '50',
                'type' => 'number',
                'description' => 'Reward amount for referred user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'reward_type',
                'value' => 'cash',
                'type' => 'string',
                'description' => 'Type of reward: cash, bonus, discount',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'referral_enabled',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable or disable referral system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_settings');
    }
};
