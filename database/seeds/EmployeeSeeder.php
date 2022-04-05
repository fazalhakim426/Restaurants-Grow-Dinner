<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([ 
            'department_id'=> 1,
            'salary' => 33500,
            'social',
            'nr',
            'bank_account',
            'documents',
        ]);
        DB::table('users')->insert([
            'first_name' => 'employee',
            'last_name' => 'LN',
            'country' => 'Pakistan',
            'phone' => '+92655678956',
            'city' => 'islambad',
            'address' => 'xyz , street s38, house 33',
            'userable_type'=>'App\Employee',
            'userable_id'=>1,
            'email' => "employee@test.com",
            'password' => Hash::make('password'),
            'created_at' => now(),
        ]);
    }
}
