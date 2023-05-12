<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'user_id' => '1',
                'company_category_id' => '1',
                'plan_id' => '1',
                'name' => "Loja Auto Peças",
                'status' => "active",
                'slug' => Str::of('Loja Auto Peças')->slug('-'),
                'document' => "83.087.431/0001-64",
                'description' => "Descrição da empresa",
            ],
            [
                'user_id' => '2',
                'company_category_id' => '1',
                'plan_id' => '1',
                'name' => "Lanternagem Dois Irmãos",
                'status' => "active",
                'slug' => Str::of('Lanternagem Dois Irmãos')->slug('-'),
                'document' => "23.131.488/0001-32",
                'description' => "Descrição da empresa",
            ],
        ];

        foreach ($companies as $key => $company) {
            try {
                Company::create($company);
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
    }
}