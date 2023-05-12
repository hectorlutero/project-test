<?php

namespace Database\Seeders;

use App\Models\CompanyCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanyCategorySeeder extends Seeder
{
    public function run(): void
    {
        $companyCategories = [
            [
                'is_active'      => 'Y',
                'allow_products' => 'Y',
                'allow_services' => 'Y',
                'name'           => 'Auto Peças',
                'slug'           => Str::of('Auto Peças')->slug('-'),
                'icon'           => 'icons/cog-engine.svg',
                'picture'        => ''
            ],
            [
                'is_active'      => 'Y',
                'allow_products' => 'Y',
                'allow_services' => 'Y',
                'name'           => 'Bateria 24hrs',
                'slug'           => Str::of('Bateria 24hrs')->slug('-'),
                'icon'           => 'icons/car-battery.svg',
                'picture'        => ''
            ],
            [
                'is_active'      => 'Y',
                'allow_products' => 'Y',
                'allow_services' => 'Y',
                'name'           => 'Guincho',
                'slug'           => Str::of('Guincho')->slug('-'),
                'icon'           => 'icons/tow-truck.svg',
                'picture'        => ''
            ],
            [
                'is_active'      => 'Y',
                'allow_products' => 'Y',
                'allow_services' => 'Y',
                'name'           => 'Motoboy de Entrega',
                'slug'           => Str::of('Motoboy de Entrega')->slug('-'),
                'icon'           => 'icons/motorcycle-delivery.svg',
                'picture'        => ''
            ],
            [
                'is_active'      => 'Y',
                'allow_products' => 'Y',
                'allow_services' => 'Y',
                'name'           => 'Oficina Mecânica',
                'slug'           => Str::of('Oficina Mecânica')->slug('-'),
                'icon'           => 'icons/car-repair.svg',
                'picture'        => ''
            ]
        ];

        foreach ($companyCategories as $key => $category) {
            try {
                CompanyCategory::create($category);
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
    }
}
