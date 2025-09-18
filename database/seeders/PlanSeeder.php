<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'price' => 299.00,
                'duration_days' => 30,
                'features' => [
                    'products' => 100,
                    'staff' => 1,
                    'qr_checkout' => true,
                    'reports' => true,
                ],
            ],
            [
                'name' => 'Pro',
                'price' => 799.00,
                'duration_days' => 30,
                'features' => [
                    'products' => 1000,
                    'staff' => 5,
                    'qr_checkout' => true,
                    'reports' => true,
                    'export' => true,
                ],
            ],
            [
                'name' => 'Enterprise',
                'price' => 1999.00,
                'duration_days' => 30,
                'features' => [
                    'products' => 'unlimited',
                    'staff' => 'unlimited',
                    'qr_checkout' => true,
                    'reports' => true,
                    'export' => true,
                    'priority_support' => true,
                ],
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
