<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('admins')->insert([]);
        DB::table('users')->insert([
            'first_name' => 'admin',
            'last_name' => 'LN',
            'country' => 'Pakistan', 
            'address' => 'Abc , street f38, house 87',
            'userable_type'=>'App\Admin',
            'userable_id'=>1,
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
        ]);
    }
}
