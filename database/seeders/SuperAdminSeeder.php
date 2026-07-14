<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin@123'),
                'role' => 'super_admin',
                'portfolio_value' => 100000,
                'total_returns' => 5000,
                'active_plans' => 1,
                'growth_rate' => 12.5,
            ]
        );
    }
}
