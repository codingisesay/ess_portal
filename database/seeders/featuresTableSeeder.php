<?php

namespace Database\Seeders;
use App\Models\feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class featuresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Feature::insert([
            [
                'module_id' => '1',
                'name' => 'show.checkin',
            ],
            [
                'module_id' => '1',
                'name' => 'show.checkout',
            ],
            [
                'module_id' => '2',
                'name' => 'employee.edit',
            ],
            [
                'module_id' => '2',
                'name' => 'employee.show',
            ],
            [
                'module_id' => '3',
                'name' => 'leave.approve',
            ],
            [
                'module_id' => '3',
                'name' => 'leave.show',
            ],
            [
                'module_id' => '4',
                'name' => 'organisation.edit',
            ],
            [
                'module_id' => '4',
                'name' => 'organisation.show',
            ],
            [
            'module_id' => '6',
            'name' => 'hr.edit',
            ],
        [
            'module_id' => '6',
            'name' => 'hr.show',
        ],
        [
            'module_id' => '7',
            'name' => 'setting.edit',
            ],
        [
            'module_id' => '7',
            'name' => 'setting.show',
        ],
        ]);
    }
}
