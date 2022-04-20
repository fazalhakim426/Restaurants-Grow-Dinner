<?php

namespace Database\Seeders;

use App\Address;
use App\BookedTable;
use App\Customer;
use App\Restaurant;
use App\Review;
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


$locations = [
    ['latitude' => '51.6056821141409' , 'longitude' => '-0.27241878747298937'],
    ['latitude' => '51.60584203446792' , 'longitude' => '-0.273620417029903'],
    ['latitude' => '51.6056821141409' , 'longitude' => '-0.2695005442633421'],
    ['latitude' => '51.6150098579756' , 'longitude' => '-0.29868297635981483'],
    ['latitude' => '51.613464250058975' , 'longitude' => '-0.29851131499454137'],
    ['latitude' => '51.604456039586815' , 'longitude' => '-0.3406541801691535'], 
    ['latitude' => '51.6056821141409' , 'longitude' => '-0.27241878747298937'],
    ['latitude' => '51.60584203446792' , 'longitude' => '-0.273620417029903'],
    ['latitude' => '51.6056821141409' , 'longitude' => '-0.2695005442633421'],
    ['latitude' => '51.6150098579756' , 'longitude' => '-0.29868297635981483'],
    ['latitude' => '51.613464250058975' , 'longitude' => '-0.29851131499454137'],
    ['latitude' => '51.604456039586815' , 'longitude' => '-0.3406541801691535'],
    ['latitude' => '51.6056821141409' , 'longitude' => '-0.27241878747298937'],
    ['latitude' => '51.60584203446792' , 'longitude' => '-0.273620417029903'],
    ['latitude' => '51.6056821141409' , 'longitude' => '-0.2695005442633421'],
    ['latitude' => '51.6150098579756' , 'longitude' => '-0.29868297635981483'],
    ['latitude' => '51.613464250058975' , 'longitude' => '-0.29851131499454137'],
    ['latitude' => '51.604456039586815' , 'longitude' => '-0.3406541801691535'],
    ['latitude' => '51.6056821141409' , 'longitude' => '-0.27241878747298937'],
    ['latitude' => '51.60584203446792' , 'longitude' => '-0.273620417029903'],
    ['latitude' => '51.6056821141409' , 'longitude' => '-0.2695005442633421'],
    ['latitude' => '51.6150098579756' , 'longitude' => '-0.29868297635981483'],
    ['latitude' => '51.613464250058975' , 'longitude' => '-0.29851131499454137'],
    ['latitude' => '51.604456039586815' , 'longitude' => '-0.3406541801691535'],
    ['latitude' => '51.6056821141409' , 'longitude' => '-0.27241878747298937'],
    ['latitude' => '51.60584203446792' , 'longitude' => '-0.273620417029903'],
    ['latitude' => '51.6056821141409' , 'longitude' => '-0.2695005442633421'],
    ['latitude' => '51.6150098579756' , 'longitude' => '-0.29868297635981483'],
    ['latitude' => '51.613464250058975' , 'longitude' => '-0.29851131499454137'],
    ['latitude' => '51.604456039586815' , 'longitude' => '-0.3406541801691535'], 
]; 


        $this->faker = Faker::create();
        $i = 0;
        while ($i < 29) {
            $i++;

            $customer = Customer::create([
                'dob' => '2000-09-08 09:03:33',
                'latitude' => '34.1891089',
                'longitude' => '73.2386739',
            ]);
            Address::create([
                'customer_id' => $customer->id,
                'title' => $this->faker->firstName,
                'address' => $this->faker->address,
                'longitude' => '34.333434334',
                'latitude' => '-73.444444444',
            ]);


            DB::table('users')->insert([
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'country_id' => 2,
                'phone' => '+9222267825' . $i,
                'address' => 'xyz , street s38, house 33',
                'userable_type' => 'App\Customer',
                'userable_id' => $customer->id,
                'email' => $i . "customer@test.com",
                'password' => Hash::make('password'),
                'created_at' => now(),
            ]);








 
            $restaurant = Restaurant::create([
                'category_id' => 1,
                'closing_time' => '17:00',
                'opening_time' => '09:00',
                'latitude' => $locations[$i]['latitude'],
                'longitude' =>$locations[$i]['longitude'],
                'description' => 'dummy description',
                'photo' => 'upload/restaurant/photo/default.png',
                'menu' => 'upload/restaurant/menu/default.png', //photo
                'instagram_link' => 'instagram.com',
                'facebook_link' => 'facebook.com',
                'twitter_link' => 'twitter.com',
                'website_link' => 'website.link',
                'informational_tags' => '30 minutes,3-5 person', 
            ]);

            $restaurant->user()->save(User::create([
                'userable_id' => $restaurant->id,
                'userable_type' => 'App\Restaurant',
                'first_name' => $this->faker->company,
                'address' => $this->faker->address,
                'country_id' => $i,
                'email' =>  $this->faker->safeEmail,
                'phone' => $this->faker->numerify('###-###-####'),
                'password' => Hash::make('password')
            ]));
            if ($i < 20) {
                VisitedRestaurant::create([
                    'employee_id' => $i,
                    'restaurant_id' => $restaurant->id,
                    'feedback' => $this->faker->text,
                    'visited_at' => '2000-08-07 12:33:33'
                ]);
            }

            $table = Table::create([
                'restaurant_id' => $restaurant->id,
                'name' => $this->faker->name,
                'number' => $i,
                'description' => $this->faker->sentence,
                'photo' => 'default.png', 
                'min_person' => $i,
                'max_person' => $i + 3,

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


            Review::create([
                'stars' => 4,
                'feedback' => $this->faker->text,
                'restaurant_id' => $restaurant->id,
                'customer_id' => $customer->id,
            ]);
        }
    }
}
