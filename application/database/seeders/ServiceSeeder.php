<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'company_id' => '2',
                "name" => "Troca de óleo",
                'slug' => Str::of('Troca de óleo')->slug('-'),
                "description" => "Troca de óleo e filtro de óleo do motor",
                "price" => 100.00,
                "execution_time" => 1,
                "is24_7" => '0',
                "working_days_start" => "08:00:00",
                "working_days_end" => "18:00:00",
                "saturdays_start" => "10:00:00",
                "saturdays_end" => "14:00:00",
                "sundays_n_holidays_start" => NULL,
                "sundays_n_holidays_end" => NULL,
            ],
            [
                'company_id' => '2',
                "name" => "Reparo de freios",
                'slug' => Str::of('Reparo de freios')->slug('-'),
                "description" => "Reparo do sistema de freios, troca de pastilhas e/ou discos de freio",
                "price" => 300.00,
                "execution_time" => 2,
                "is24_7" => '0',
                "working_days_start" => "08:00:00",
                "working_days_end" => "18:00:00",
                "saturdays_start" => "10:00:00",
                "saturdays_end" => "14:00:00",
                "sundays_n_holidays_start" => NULL,
                "sundays_n_holidays_end" => NULL,
            ],
            [
                'company_id' => '1',
                "name" => "Instalação de som automotivo",
                'slug' => Str::of('Instalação de som automotivo')->slug('-'),
                "description" => "Instalação de sistema de som automotivo, incluindo alto-falantes, subwoofers e amplificadores",
                "price" => 500.00,
                "execution_time" => 4,
                "is24_7" => '0',
                "working_days_start" => "08:00:00",
                "working_days_end" => "18:00:00",
                "saturdays_start" => "10:00:00",
                "saturdays_end" => "14:00:00",
                "sundays_n_holidays_start" => NULL,
                "sundays_n_holidays_end" => NULL,
            ],
            [
                'company_id' => '1',
                "name" => "Lavagem e limpeza automotiva",
                'slug' => Str::of('Lavagem e limpeza automotiva')->slug('-'),
                "description" => "Lavagem e limpeza completa do veículo, incluindo enceramento e aspiração interna",
                "price" => 80.00,
                "execution_time" => 2,
                "is24_7" => '1',
                "working_days_start" => NULL,
                "working_days_end" => NULL,
                "saturdays_start" => NULL,
                "saturdays_end" => NULL,
                "sundays_n_holidays_start" => NULL,
                "sundays_n_holidays_end" => NULL,
            ],
        ];


        foreach ($services as $key => $service) {
            try {
                Service::create($service);
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
    }
}