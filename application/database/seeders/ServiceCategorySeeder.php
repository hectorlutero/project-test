<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $servicesCategories = [
            [
                "name" => "Serviços de manutenção",
                'slug' => Str::of('Serviços de manutenção')->slug('-'),
            ],
            [
                "name" => "Serviços de reparo",
                'slug' => Str::of('Serviços de reparo')->slug('-'),
            ],
            [
                "name" => "Serviços de instalação",
                'slug' => Str::of('Serviços de instalação')->slug('-'),
            ],
            [
                "name" => "Serviços de diagnóstico",
                'slug' => Str::of('Serviços de diagnóstico')->slug('-'),
            ],
            [
                "name" => "Serviços de limpeza",
                'slug' => Str::of('Serviços de limpeza')->slug('-'),
            ],
        ];

        foreach ($servicesCategories as $key => $serviceCategory) {
            try {
                ServiceCategory::create($serviceCategory);
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
    }
}
