<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'company_id' => '1',
                "name" => "Bateria de carro",
                'slug' => Str::of('Bateria de carro')->slug('-'),
                "description" => "Bateria para veículos",
                "model" => "ABC-123",
                "sku" => "BATABC123",
                "stock" => 50,
                "price" => 399.99,
            ],
            [
                'company_id' => '1',
                "name" => "Pneu para carro",
                'slug' => Str::of('Pneu para carro')->slug('-'),
                "description" => "Pneu para veículos",
                "model" => "DEF-456",
                "sku" => "PNDEF456",
                "stock" => 100,
                "price" => 189.99,
            ],
            [
                'company_id' => '2',
                "name" => "Pastilha de freio",
                'slug' => Str::of('Pastilha de freio')->slug('-'),
                "description" => "Pastilha de freio para veículos",
                "model" => "GHI-789",
                "sku" => "PFGHI789",
                "stock" => 200,
                "price" => 49.99,
            ],
            [
                'company_id' => '2',
                "name" => "Óleo de motor",
                'slug' => Str::of('Óleo de motor')->slug('-'),
                "description" => "Óleo para motor de veículos",
                "model" => "JKL-012",
                "sku" => "OLJKL012",
                "stock" => 150,
                "price" => 69.99,
            ],
            [
                'company_id' => '1',
                "name" => "Filtro de ar",
                'slug' => Str::of('Filtro de ar')->slug('-'),
                "description" => "Filtro de ar para veículos",
                "model" => "MNO-345",
                "sku" => "FTMNO345",
                "stock" => 80,
                "price" => 19.99,
            ],
        ];


        foreach ($products as $key => $product) {
            try {
                Product::create($product);
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
    }
}