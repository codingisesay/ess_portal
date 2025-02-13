<?php

namespace Database\Seeders;
use App\Models\organisation_buy_module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class organisationbuyModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        organisation_buy_module::insert(
            [
                [
                    'module_id' => '1',
                    'organisation_id' => '1',
                    'created_at' => NOW(),
                    'updated_at' => NOW(),
                ],
                [
                    'module_id' => '2',
                    'organisation_id' => '1',
                    'created_at' => NOW(),
                    'updated_at' => NOW(),
                ],
                [
                    'module_id' => '3',
                    'organisation_id' => '1',
                    'created_at' => NOW(),
                    'updated_at' => NOW(),
                ],
                [
                    'module_id' => '4',
                    'organisation_id' => '1',
                    'created_at' => NOW(),
                    'updated_at' => NOW(),
                ],
                [
                    'module_id' => '5',
                    'organisation_id' => '1',
                    'created_at' => NOW(),
                    'updated_at' => NOW(),
                ],
                [
                    'module_id' => '6',
                    'organisation_id' => '1',
                    'created_at' => NOW(),
                    'updated_at' => NOW(),
                ],
                [
                    'module_id' => '7',
                    'organisation_id' => '1',
                    'created_at' => NOW(),
                    'updated_at' => NOW(),
                ]
            ]
        );
    }
        
    }

