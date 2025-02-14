<?php

namespace Database\Seeders;
use App\Models\qualification_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class qualification_typesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.gi
     */
    public function run()
    {
        qualification_type::insert([
            [
                'qualification_id' => '',
                'name' => '',
                'created_at' => '',
                'updated_at' => '',
            ]
            ]);
    }
}
