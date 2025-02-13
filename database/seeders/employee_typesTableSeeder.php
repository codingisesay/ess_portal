<?php

namespace Database\Seeders;
use App\Models\employee_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class employee_typesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        employee_type::insert([
            [
                'name' => 'permanent',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'name' => 'contract',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]
        ]);
    }
}
