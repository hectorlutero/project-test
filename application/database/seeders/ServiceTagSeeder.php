<?php

namespace Database\Seeders;

use App\Models\ServiceTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceTagSeeder extends Seeder
{
    public function run(): void
    {
        $servicesTags = [
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


        foreach ($servicesTags as $key => $serviceTag) {
            try {
                ServiceTag::create($serviceTag);
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
    }
}
