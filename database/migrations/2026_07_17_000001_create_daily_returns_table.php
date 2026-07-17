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
        Schema::create('daily_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('return_date');
            $table->decimal('return_percentage', 8, 4)->default(0); // daily return %
            $table->decimal('return_amount', 15, 2)->default(0);    // absolute amount earned
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'return_date']); // one record per user per day
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_returns');
    }
};
