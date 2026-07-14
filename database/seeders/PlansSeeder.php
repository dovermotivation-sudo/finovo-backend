<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter Plan',
                'plan_type' => 'Flexible Investment Packages',
                'description' => 'Perfect for beginners',
                'roi' => '8-12%/Monthly',
                'minimum_investment' => '₹10,000',
                'risk_level' => 'Low Risk Portfolio',
                'report_frequency' => 'Monthly Reports',
                'support_type' => 'Basic Support',
                'activation_time' => null,
                'other_features' => json_encode([
                    'features' => [
                        'Minimum Investment' => '₹10,000',
                        'Low Risk Portfolio' => true,
                        'Monthly Reports' => true,
                        'Basic Support' => true
                    ]
                ]),
            ],
            [
                'name' => 'Most Popular',
                'plan_type' => 'Flexible Investment Packages',
                'description' => 'Growth Plan For serious investors',
                'roi' => '15-20%/Monthly',
                'minimum_investment' => '₹50,000',
                'risk_level' => 'Balanced Risk Portfolio',
                'report_frequency' => 'Weekly Reports',
                'support_type' => 'Priority Support',
                'activation_time' => null,
                'other_features' => json_encode([
                    'features' => [
                        'Minimum Investment' => '₹50,000',
                        'Balanced Risk Portfolio' => true,
                        'Weekly Reports' => true,
                        'Priority Support' => true
                    ]
                ]),
            ],
            [
                'name' => 'Premium',
                'plan_type' => 'Flexible Investment Packages',
                'description' => 'For high net worth individuals',
                'roi' => '25-35%/Monthly',
                'minimum_investment' => '₹2,00,000',
                'risk_level' => 'High Growth Portfolio',
                'report_frequency' => 'Daily Reports',
                'support_type' => 'Dedicated Manager',
                'activation_time' => null,
                'other_features' => json_encode([
                    'features' => [
                        'Minimum Investment' => '₹2,00,000',
                        'High Growth Portfolio' => true,
                        'Daily Reports' => true,
                        'Dedicated Manager' => true
                    ]
                ]),
            ],
            [
                'name' => 'Crypto',
                'plan_type' => 'Smart Bot Packages',
                'description' => '',
                'roi' => '25% per month (Monthly Selling), 38% per month (If Holding Stock)',
                'minimum_investment' => '$1000',
                'risk_level' => 'Systematic perilous',
                'report_frequency' => 'Monthly Reports',
                'support_type' => 'Dedicated account manager, 24/7 technical support',
                'activation_time' => '24 hr activation',
                'other_features' => json_encode([
                    'features' => [
                        'Price' => '$499/ life time',
                        'Minimum Deposit' => '1000$',
                        'ROI Monthly Selling' => '25%',
                        'ROI Holding Stock' => '38%',
                        'Dedicated account manager' => true,
                        '24/7 technical support' => true,
                        '24 hr activation' => true,
                        'Systematic perilous' => true
                    ]
                ]),
            ],
            [
                'name' => 'Commodities',
                'plan_type' => 'Smart Bot Packages',
                'description' => '',
                'roi' => '30% per month (Monthly Selling), 42% per month (If Holding Stock)',
                'minimum_investment' => '$2000',
                'risk_level' => 'Systematic perilous',
                'report_frequency' => 'Monthly Reports',
                'support_type' => 'Dedicated account manager, 24/7 technical support',
                'activation_time' => '6 hr activation',
                'other_features' => json_encode([
                    'features' => [
                        'Price' => '$399/life time',
                        'Minimum Deposit' => '2000$',
                        'ROI Monthly Selling' => '30%',
                        'ROI Holding Stock' => '42%',
                        '24/7 technical support' => true,
                        '6 hr activation' => true,
                        'Unlimited option' => true,
                        'Dedicated account manager' => true,
                        'Systematic perilous' => true
                    ]
                ]),
            ],
            [
                'name' => 'Customize Software',
                'plan_type' => 'Smart Bot Packages',
                'description' => '',
                'roi' => 'Customizable',
                'minimum_investment' => 'Customized',
                'risk_level' => 'Systematic perilous',
                'report_frequency' => 'Customizable Reports',
                'support_type' => 'Dedicated Manager, 24/7 technical support',
                'activation_time' => null,
                'other_features' => json_encode([
                    'features' => [
                        'Price' => '$899/life time',
                        'Customize Deposit' => true,
                        'Customize profit ROI' => true,
                        'Customize risk' => true,
                        'Unlimited trading symbols' => true,
                        '24/7 technical support' => true,
                        'Dedicated Manager' => true,
                        'Systematic perilous' => true
                    ]
                ]),
            ],
        ];

        foreach ($plans as $planData) {
            Plan::updateOrCreate(
                ['name' => $planData['name']], // Unique key
                $planData
            );
        }
    }
}
