<?php

namespace Database\Seeders;

use App\BookedTable;
use App\Customer;
use App\Restaurant;
use App\Table;
use App\User;
use App\VisitedRestaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $this->faker = Faker::create();
        $i=0;
        while($i<30){
            $i++;
            
         $customer = Customer::create([ 
             'dob'=> '2000-09-08 09:03:33', 
             'latitude'=>'34.1891089', 
             'longitude'=>'73.2386739',
         ]);
         DB::table('users')->insert([
             'first_name' => $this->faker->text,
             'last_name' => $this->faker->text,
             'country_id' => 2,
             'phone' => '+9222267825'.$i, 
             'address' => 'xyz , street s38, house 33',
             'userable_type'=>'App\Customer',
             'userable_id'=> $customer->id,
             'email' => $i."customer@test.com",
             'password' => Hash::make('password'),
             'created_at' => now(),
         ]);
     
         







        $i++; 
        $restaurant = Restaurant::create([ 
            'category_id'=> 1,
            'closing_time'=> '17:00',
            'opening_time'=> '09:00', 
            'latitude'=> '34.'.$i.'4312',
            'longitude'=> '-73.159848',
            'description'=> 'dummy description', 
            'photo'=>'default.png',
            'menu'=> 'default.png',//photo
            'instagram_link'=> 'instagram.com',
            'facebook_link'=> 'facebook.com',
            'twitter_link'=> 'twitter.com',
            'website_link'=> 'website.link',
            'informational_tags'=> '30 minutes,3-5 person',
            'active'=>false,
             ]); 

         $restaurant->user()->save(User::create([
            'userable_id' => $restaurant->id,
            'userable_type' => 'App\Restaurant', 
            'first_name'=> $this->faker->company , 
            'address'=> $this->faker->address ,
            'country_id'=> $i, 
            'email'=>  $this->faker->safeEmail,
            'phone'=> $this->faker->numerify('###-###-####') ,  
            'password'=> Hash::make('password')
        ])); 
         if($i<20){
              VisitedRestaurant::create([
            'employee_id' => $i,
            'restaurant_id' => $restaurant->id,
            'feedback' => $this->faker->text ,
            'visited_at' =>'2000-08-07 12:33:33'
        ]);  
         }
       
        $table = Table::create([
            'restaurant_id' => $restaurant->id,
            'name' => $this->faker->name,
            'number' =>$i,
            'description' => $this->faker->sentence,
            'photo' => 'default.png',
  
          ]);
          BookedTable::create([
              'customer_id' => $customer->id,
              'table_id' => $table->id,
              'date' => '2022-04-10',
               'time_slot' => '09:00 - 09:30',
          ]);

          BookedTable::create([
              'customer_id' => $customer->id,
              'table_id' => $table->id,
              'date' => '2022-04-10',
               'time_slot' => '11:00 - 11:30',
          ]);
 

           }
    }
}
