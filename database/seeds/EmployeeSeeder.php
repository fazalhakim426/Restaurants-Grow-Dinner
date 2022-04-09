<?php

namespace Database\Seeders;

use App\Employee;
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
        $i = 0;
        while($i<30){
           $i++;
           
        $employee = Employee::create([ 
            'department_id'=> 1,
            'salary' => 33500,
            'social_nr'=>'socail nr', 
            'bank_account'=>'UNIL3456897654345689',
            'documents'=>'documents',
        ]);
        DB::table('users')->insert([
            'first_name' => 'employee',
            'last_name' => 'LN',
            'country_id' => 2,
            'phone' => '+9265567825'.$i, 
            'address' => 'xyz , street s38, house 33',
            'userable_type'=>'App\Employee',
            'userable_id'=> $employee->id,
            'email' => $i."employee@test.com",
            'password' => Hash::make('password'),
            'created_at' => now(),
        ]);
    } 
}
}
