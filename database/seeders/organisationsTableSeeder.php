<?php

namespace Database\Seeders;
use App\Models\organisation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class organisationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        organisation::create([

            'name' => 'SIL Tech PVT',
            'email' => 'info@siltech.co.in',
            'password' => Hash::make('akash@1234'),
            'mobile' => '6394877241',
            'building_no' => 'A-112',
            'premises_name' => 'Centrum',
            'landmark' => 'Petrol pump',
            'road_street' => 'Gandhi Road',
            'pincode' => '110005',
            'district' => 'Mumbai',
            'state' => 'maharashtra',
            'country' => 'India',
            'created_at' => NOW(),
            'updated_at' => NOW(),

        ]);
    }
}
