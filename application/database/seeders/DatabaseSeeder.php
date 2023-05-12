<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            PermissionTableSeeder::class,
            RoleSeeder::class,
            AdminUserSeeder::class,
            CompanyCategorySeeder::class,
            PlanSeeder::class,
            CompanySeeder::class,
            ProductSeeder::class,
            ProductCategorySeeder::class,
            ProductTagSeeder::class,
            ServiceSeeder::class,
            ServiceTagSeeder::class,
            ServiceCategorySeeder::class,
            DashboardTableSeeder::class,
        ]);

    }
}
