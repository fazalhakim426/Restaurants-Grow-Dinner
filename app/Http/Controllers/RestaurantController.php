<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRestaurantRequest;
use App\Http\Requests\RestaurantUpdateRequest;
use App\Http\Requests\RestaurantRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\RestaurantResource;
use App\Restaurant;
use App\User;
use App\VisitedRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RestaurantController extends Controller
{

//     function distance($lat1, $lon1, $lat2, $lon2, $unit) {

//         $theta = $lon1 - $lon2;
//         $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
//         $dist = acos($dist);
//         $dist = rad2deg($dist);
//         $miles = $dist * 60 * 1.1515;
//         $unit = strtoupper($unit);
      
//         if ($unit == "K") {
//             return ($miles * 1.609344);
//         } else if ($unit == "N") {
//             return ($miles * 0.8684);
//         } else {
//             return $miles;
//         }
//    } 

    public function index()
    { 
        $options = json_decode(request()->options);
        $page = $options ? $options->page : 1; 
        $itemsPerPage = $options?$options->itemsPerPage:-1;
        $sortBy = $options?$options->sortBy:'distance';
        $sortDesc = $options?($options->sortDesc?'DESC':'ASC'):'ASC';  
        $major_query = $this->index_major_query();
        $count = $major_query->count();  
         
            $restaurant = $major_query
            ->when($itemsPerPage != -1,
                    function ($query) use ($itemsPerPage, $page) {
                        return $query->offset($itemsPerPage * ($page - 1))->take($itemsPerPage);
                    }
                )
                ->orderBy($sortBy, $sortDesc) 
                ->get();


        return response()->json([
            "success" => true,
            "total" => $count,
            "message" => "Restaurant List",
            "data" =>  RestaurantResource::collection($restaurant)
        ]);
    }

    public function employee_index()
    {
        
        
        $options = json_decode(request()->options);
        $page = $options ? $options->page : 1; 
        $itemsPerPage = $options?$options->itemsPerPage:-1;
        $sortBy = $options?$options->sortBy:'id';
        $sortDesc = $options?$options->sortDesc:'ASC';   
         
         $auth_user = Auth::user();
         $major_query= $this->index_major_query();

        $query =$major_query->whereHas('visited_restaurant', function ($q) use ($auth_user) {
             $q->where('employee_id', $auth_user->userable_id);
        });



            $count = $query->count();

            $restaurant = $query->when(
                $itemsPerPage != -1,
                function ($query) use ($itemsPerPage, $page) {
                    return $query->offset($itemsPerPage * ($page - 1))
                        ->take($itemsPerPage);
                }
            )->orderBy($sortBy, $sortDesc ? 'DESC' : 'ASC')->get();
         
     

        return response()->json([
            "success" => true,
            "total" => $count,
            "message" => "Restaurant List",
            "data" =>  RestaurantResource::collection($restaurant)
        ]);
    }
    public function index_major_query()
    { 
        $auth_user = Auth::user();
        $customer = $auth_user->userable;
        if(request()->latitude && request()->longitude){ 
            $customer->update([
                "latitude"=> request()->latitude, 
                "longitude"=> request()->longitude,
            ]);
        }  
        $latitude = $customer->latitude;
        $longitude = $customer->longitude; 

        $mile = request()->distance?request()->distance:6; 

        $q = request()->q;
        $country_id = request()->country_id;
        $category_id = request()->category_id; 
        return
        Restaurant::select(DB::raw("id, ( 3959 * acos( cos( radians('$latitude') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( latitude ) ) ) ) AS distance"))
        ->havingRaw("distance < '$mile'")
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

    public function admin_store(RestaurantRequest $request)
    {
        $data = $request->all();
        if ($request->photo) {
            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads/restaurant'), $fileName);
            $data['photo'] = 'uploads/restaurant/' . $fileName;
        }
        if ($request->menu) {
            $fileName = time() . '.' . $request->menu->extension();
            $request->menu->move(public_path('uploads/restaurant/menu'), $fileName);
            $data['menu'] = 'uploads/restaurant/' . $fileName;
        }

        $data['password'] =  Hash::make($request->password);

        $restaurant = Restaurant::create($data);
        $data['userable_type'] = 'App\Restaurant';
        $data['userable_id'] = $restaurant->id;
        $restaurant->user()->save(User::create($data));
        return response()->json([
            "success" => true,
            "message" => "Restaurant created successfully.",
            "data" => new RestaurantResource($restaurant),
        ], 201);
    }

    public function employee_store(EmployeeRestaurantRequest $request)
    {

        $data = $request->all();
        if ($request->photo) {
            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads/restaurant'), $fileName);
            $data['photo'] = 'uploads/restaurant/' . $fileName;
        }
        if ($request->menu) {
            $fileName = time() . '.' . $request->menu->extension();
            $request->menu->move(public_path('uploads/restaurant/menu'), $fileName);
            $data['menu'] = 'uploads/restaurant/' . $fileName;
        }

        $data['password'] =  Hash::make($request->password);

        $restaurant = Restaurant::create($data);
        $data['userable_type'] = 'App\Restaurant';
        $data['userable_id'] = $restaurant->id;

        $restaurant->user()->save(User::create($data));

        VisitedRestaurant::create([
            'employee_id' => Auth::user()->userable_id,
            'restaurant_id' => $restaurant->id,
            'feedback' => $request->feedback,
            'visited_at' => $request->visited_at
        ]);

        return response()->json([
            "success" => true,
            "message" => "Restaurant created successfully.",
            "data" => new RestaurantResource($restaurant),
        ], 201);
    }

    public function admin_update(RestaurantUpdateRequest $request, $id)
    {
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            $restaurant->update($request->all());
            $user = $restaurant->user;

            $request->validate([
                'email' => 'email|unique:users,email,' . $user->id,
            ]);
            $user->update($request->all());
            if ($request->documents) {
                $fileName = time() . '.' . $request->documents->extension();
                $request->documents->move(public_path('uploads/restaurant'), $fileName);
                $restaurant->update(['documents' => 'uploads/restaurant/' . $fileName]);
            }
            if ($request->password) {
                $restaurant->user->update(['password' => Hash::make($request->password)]);
            }
            $restaurant->refresh();
            return response()->json([
                "success" => true,
                "message" => "Updated successfully.",
                "data" => new RestaurantResource($restaurant)
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Restaurant not found."
            ]);
        }
    }
    public function employee_update(RestaurantUpdateRequest $request, $id)
    {
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            $restaurant->update($request->all());
            $user = $restaurant->user;
            $request->validate([
                'email' => 'email|unique:users,email,' . $user->id,
            ]);
            $user->update($request->all());
            if ($request->documents) {
                $fileName = time() . '.' . $request->documents->extension();
                $request->documents->move(public_path('uploads/restaurant'), $fileName);
                $restaurant->update(['documents' => 'uploads/restaurant/' . $fileName]);
            }
            if ($request->password) {
                $restaurant->user->update(['password' => Hash::make($request->password)]);
            }

            $restaurant->visited_restaurant->update([
                'employee_id' => Auth::user()->userable_id,
                'restaurant_id' => $restaurant->id,
                'feedback' => $request->feedback,
                'visited_at' => $request->visited_at
            ]);

            $restaurant->refresh();
            return response()->json([
                "success" => true,
                "message" => "Updated successfully.",
                "data" => new RestaurantResource($restaurant)
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Restaurant not found."
            ]);
        }
    }
    public function show($id)
    {
        $restaurant = Restaurant::find($id);
        if (is_null($restaurant)) {
            return response()->json([
                "success" => false,
                "message" => "Restaurant not Found!"
            ], 401);
        }
        return response()->json([
            "success" => true,
            "message" => "Restaurant retrieved successfully.",
            "data" => new RestaurantResource($restaurant)
        ]);
    }
    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            $restaurant->user->delete();
            $restaurant->delete();
            return response()->json([
                "success" => true,
                "message" => "Restaurant deleted successfully."
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Restaurant not found."
            ]);
        }
    }
}
