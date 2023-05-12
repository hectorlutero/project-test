<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function PHPSTORM_META\map;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'is_active' => 'Y',
                'name' => 'Free',
                'price' => 0,
                'duration' => '0',
                'description' => 'Plano livre de cobranças',
            ],
            [
                'is_active' => 'Y',
                'name' => 'Premium',
                'price' => 59.90,
                'duration' => '0',
                'description' => 'Plano Premium com destaque',
            ],
            [
                'is_active' => 'Y',
                'name' => 'On Demand',
                'price' => 19.90,
                'duration' => '0',
                'description' => 'Plano sob demanda ou por período',
            ]
        ];

        foreach ($plans as $key => $plan) {
            try {
                Plan::create($plan);
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
    }
}