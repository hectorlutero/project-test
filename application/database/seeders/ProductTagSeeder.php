<?php

namespace Database\Seeders;

use App\Models\ProductTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductTagSeeder extends Seeder
{
    public function run(): void
    {
        $productsTags = [
            [
                "name" => "Troca de óleo",
            ],
            [
                "name" => "Troca de pneus",
            ],
            [
                "name" => "Alinhamento",
            ],
            [
                "name" => "Balanceamento",
            ],
            [
                "name" => "Reparo de freios",
            ],
            [
                "name" => "Substituição de correias",
            ],
            [
                "name" => "Troca de bateria",
            ],
            [
                "name" => "Instalação de som automotivo",
            ],
            [
                "name" => "Diagnóstico de problemas elétricos",
            ],
            [
                "name" => "Lavagem e limpeza automotiva",
            ],
        ];


        foreach ($productsTags as $key => $productTag) {
            try {
                ProductTag::create($productTag);
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
    }
}
