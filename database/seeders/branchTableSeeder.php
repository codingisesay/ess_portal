<?php

namespace Database\Seeders;
use App\Models\branche;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class branchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        branche::insert([
            'organisation_id' => '1',
            'name' => 'Nehru Place, New Delhi',
            'mobile' => '6394877241',
            'branch_email' => 'xyz@gmail.com'
        ]);
    }
}
