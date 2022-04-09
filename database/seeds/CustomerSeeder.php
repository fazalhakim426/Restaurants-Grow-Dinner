<?php

namespace Database\Seeders;


use App\Restaurant;
use App\User;
use App\VisitedRestaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Faker\Factory as Faker;
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
        
        $i=1;
        while($i<30){
        $i++; 
        $restaurant = Restaurant::create([ 
            'category_id'=> 1,
            'closing_time'=> '17:00',
            'opening_time'=> '09:00', 
            'latitude'=> '1.222222222',
            'longitude'=> '2.333333333333',
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
            'phone'=> '+3534534535'.$i ,  
            'password'=> Hash::make('password')
        ])); 
         if($i<20)
         VisitedRestaurant::create([
            'employee_id' => $i,
            'restaurant_id' => $restaurant->id,
            'feedback' => $this->faker->text ,
            'visited_at' =>'2000-08-07 12:33:33'
        ]); 
    }
    }
}
