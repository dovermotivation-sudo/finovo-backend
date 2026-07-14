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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('referred_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('referral_code', 20);
            $table->enum('status', ['pending', 'active', 'rewarded'])->default('pending');
            $table->timestamp('referred_at');
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('rewarded_at')->nullable();
            $table->timestamps();
            
            $table->index(['referrer_id', 'status']);
            $table->index('referred_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
