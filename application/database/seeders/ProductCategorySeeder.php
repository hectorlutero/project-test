<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $productsCategories = [
            [
                "name" => "Componentes e peças do piso",
                'slug' => Str::of('Componentes e peças do piso')->slug('-'),
            ],
            [
                "name" => "Assento de carro",
                'slug' => Str::of('Assento de carro')->slug('-'),
            ],
            [
                "name" => "Componentes e peças do motor",
                'slug' => Str::of('Componentes e peças do motor')->slug('-'),
            ],
            [
                "name" => "Elétrica e eletrônica",
                'slug' => Str::of('Elétrica e eletrônica')->slug('-'),
            ],
            [
                "name" => "Sistema de alimentação de combustível",
                'slug' => Str::of('Sistema de alimentação de combustível')->slug('-'),
            ],
            [
                "name" => "Sistema de freio",
                'slug' => Str::of('Sistema de freio')->slug('-'),
            ],
            [
                "name" => "Corpo e peças principais",
                'slug' => Str::of('Corpo e peças principais')->slug('-'),
            ],
        ];

        foreach ($productsCategories as $key => $productCategory) {
            try {
                ProductCategory::create($productCategory);
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
    }
}
