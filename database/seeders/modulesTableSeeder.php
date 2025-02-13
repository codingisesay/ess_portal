<?php

namespace Database\Seeders;
use App\Models\module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class modulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Module::insert([
            [
                'name' => 'Dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Employee Details',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Leave & Attendance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Organizations Chart',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PMS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HR Policy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Settings',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

}
