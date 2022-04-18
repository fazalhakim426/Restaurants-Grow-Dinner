<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantResource;
use App\Restaurant;
use App\Setting; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class CustomerRestaurantController extends Controller
{
    public function index()
    { 
        $options = json_decode(request()->options); 
  
        $page = $options ? $options->page : 1; 
        $itemsPerPage = $options?$options->itemsPerPage:-1;
        $sortBy = $options?$options->sortBy:'distance';
        $sortDesc = $options?($options->sortDesc?'DESC':'ASC'):'ASC'; 
 
            // dd(json_decode(request()->options));

        $distanceSetting = Setting::where('key','distance')->first(); 
        $distance = $distanceSetting->value?$distanceSetting->value:6; 
        $mile = request()->distance? request()->distance:$distance; 
 

        $major_query = $this->customer_major_query($mile);
        $count = $major_query->count();  
         
            $restaurant = $major_query
            ->when($itemsPerPage != -1,
                    function ($query) use ($itemsPerPage, $page) {
                        return $query->offset($itemsPerPage * ($page - 1))->take($itemsPerPage);
                    })->when($sortBy=='popular',function($q){ 
                   return $q->orderBy('reviews_count', 'DESC') 
                            ->orderBy('booked_tables_count', 'DESC');
                })->when($sortBy=='distance',function($q) use($sortBy,$sortDesc,$mile){
                     return  $q->orderBy($sortBy, $sortDesc);
                })->get(); 
//   $restaurant = $restaurant->sortBy(function($review){
//             return $review->booked_tables_count+$review->review_count+$review->rating;
//         }); 

        return response()->json([ 
            "success" => true,
            'distance' => 'In '.$mile.' mile',
            "total" => $count,
            "message" => ($sortBy=='popular'?'Popular':'Nearby') ." Restaurant List",
            "data" =>   RestaurantResource::collection($restaurant),
        ]);
    }
  

   
 

   
    public function customer_major_query($mile)
    { 

        $auth_user = Auth::user();
        $customer = $auth_user->userable;
        
        if(request()->latitude && request()->longitude){ 
            $customer->update([
                "latitude"=> request()->latitude, 
                "longitude"=> request()->longitude,
            ]);
            if(request()->address){
               $customer->userable->update([
                   'address'=> request()->address
               ]);
            }
        }
        
        $latitude = $customer->latitude;
        $longitude = $customer->longitude;  
        $q = request()->q;
        $country_id = request()->country_id;
        $category_id = request()->category_id; 
        return
        Restaurant::
        select(DB::raw("*, ( 3959 * acos( cos( radians('$latitude') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( latitude ) ) ) ) AS distance"))
        ->withCount('reviews') 
        ->with('reviews') 
        ->withCount('bookedTables') 
        ->havingRaw("distance < '$mile'")
        ->whereHas('category',function($query){ 
            $query->where('active',isset(request()->active)?request()->active:1);
       })->whereHas('user',function($query){ 
           $query->where('active',isset(request()->active)?request()->active:1); 
       }) 
        ->when($category_id, function ($q) use ($category_id) {
            return $q->where('category_id', $category_id);
        }) 
        ->when($country_id, function ($q) use ($country_id) {
         return $q->whereHas('user', function ($q) use ($country_id) {
            return $q->where('country_id', $country_id);
        });
        })->whereHas('user', function ($query) use ($q) { 
            return $query->where(function ($query) use ($q) {
                $query->orWhere('first_name', 'LIKE', '%' . $q . '%')
                      ->orWhere('email', 'LIKE', '%' .  $q . '%')
                      ->orWhere('address', 'LIKE', '%' . $q . '%');
            });
        })->when($q, function ($query) use ($q) {
            return $query->orwhere(function ($query) use ($q) {
                $query->orWhere('description', 'LIKE', '%' . $q . '%');
            });
        });
    }


}
