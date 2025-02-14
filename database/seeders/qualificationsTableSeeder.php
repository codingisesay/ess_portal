<?php

namespace Database\Seeders;
use App\Models\qualification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class qualificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        qualification::insert([
            [
                'name' => 'Degree',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'name' => 'Certificate',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]
        ]);
    }
}
