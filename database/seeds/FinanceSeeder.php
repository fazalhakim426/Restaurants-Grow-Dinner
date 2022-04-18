<?php

namespace Database\Seeders;

use App\Finance;
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
        $finance = Finance::create([]);
        DB::table('users')->insert([
            'first_name' => 'Finance',
            'last_name' => 'LN',
            'country_id' => 1, 
            'address' => 'Abc , street f38, house 87',
            'userable_type'=>'App\Finance',
            'userable_id'=> $finance->id,
            'email' => 'finance2@test.com',
            'phone' => '92655338956',
            'password' => Hash::make('password'),
            'created_at' => now(),
        ]);
    }
}
