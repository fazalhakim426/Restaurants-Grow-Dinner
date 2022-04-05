<?php

use App\Country;
use App\Department;
use Database\Seeders\AdminSeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\FinanceSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
             CountrySeeder::class,  
             AdminSeeder::class,
             FinanceSeeder::class,
            //  EmployeeSeeder::class,
             CustomerSeeder::class,
        ]);
        
        // Department::factory()->count(5)->create(); 
        // Country::factory()->count(10)->create(); 
    }
}
