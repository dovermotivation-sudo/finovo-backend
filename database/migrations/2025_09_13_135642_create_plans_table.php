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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_type'); // e.g., Flexible Investment Packages, Smart Bot Packages
            $table->string('name')->unique(); // Plan name must be unique
            $table->text('description')->nullable();
            $table->string('roi')->nullable(); // e.g., 8-12%/Monthly
            $table->string('minimum_investment')->nullable(); // e.g., ₹10,000 or Customized
            $table->string('risk_level')->nullable(); // e.g., Low Risk Portfolio
            $table->string('report_frequency')->nullable(); // e.g., Monthly Reports
            $table->string('support_type')->nullable(); // e.g., Basic Support
            $table->string('activation_time')->nullable(); // e.g., 24 hr activation
            $table->json('other_features')->nullable(); // JSON field to store extra features
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
