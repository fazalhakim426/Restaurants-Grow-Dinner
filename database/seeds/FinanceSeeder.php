<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FinanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('finances')->insert([ 
        ]);
        DB::table('users')->insert([
            'first_name' => 'admin',
            'last_name' => 'LN', 
            'country' => 'Pakistan', 
            'address' => 'Abc , street f38, house 87',
            'userable_type'=>'App\Finance',
            'userable_id'=>1,
            'email' => 'finance@test.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
        ]);
    }
}
