<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(organisationsTableSeeder::class);
        $this->call(modulesTableSeeder::class);
        $this->call(branchTableSeeder::class);
        $this->call(organisationbuyModuleTableSeeder::class);
        $this->call(featuresTableSeeder::class);
        $this->call(employee_typesTableSeeder::class);
    }
}
