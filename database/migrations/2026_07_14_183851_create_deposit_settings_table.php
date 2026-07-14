<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deposit_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed initial values for BEP20 and TRC20 networks
        DB::table('deposit_settings')->insert([
            [
                'key' => 'bep20_address',
                'value' => '0x0000000000000000000000000000000000000000',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'bep20_qr_code',
                'value' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'trc20_address',
                'value' => 'T000000000000000000000000000000000',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'trc20_qr_code',
                'value' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_settings');
    }
};
