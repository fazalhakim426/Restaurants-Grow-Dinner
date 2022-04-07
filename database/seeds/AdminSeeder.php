<?php

namespace Database\Seeders;

use App\Admin;
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
        $admin = Admin::create([]);
        DB::table('users')->insert([
            'first_name' => 'admin',
            'last_name' => 'LN',
            'country' => 'Pakistan', 
            'address' => 'Abc , street f38, house 87',
            'userable_type'=>'App\Admin',
            'userable_id'=> $admin->id,
            'email' => 'admin@test.com',
            'phone' => '92655678956',
            'password' => Hash::make('password'),
            'created_at' => now(),
        ]);
    }
}
