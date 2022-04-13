<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRestaurantRequest;
use App\Http\Requests\RestaurantUpdateRequest;
use App\Http\Resources\RestaurantResource;
use App\Restaurant;
use App\Setting;
use App\User;
use App\VisitedRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeRestaurantController extends Controller
{
    public function index()
    {
        $options = json_decode(request()->options);
        $page = $options ? $options->page : 1;
        $itemsPerPage = $options ? $options->itemsPerPage : -1;
        $sortBy = $options ? $options->sortBy : 'id';
        $sortDesc = $options ? $options->sortDesc : 'ASC';

        $distanceSetting = Setting::where('key', 'distance')->first();
        $distance = $distanceSetting->value ? $distanceSetting->value : 6;
        $mile = request()->distance ? request()->distance : $distance;


        $auth_user = Auth::user();
        $major_query = $this->employee_major_query($mile);

        $query = $major_query->whereHas('visited_restaurant', function ($q) use ($auth_user) {
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

    public function employee_major_query()
    {

        $q = request()->q;
        $country_id = request()->country_id;
        $category_id = request()->category_id;
        return
            Restaurant::when($category_id, function ($q) use ($category_id) {
                return $q->where('category_id', $category_id);
            })
            ->whereHas('category',function($query){ 
                $query->where('active',isset(request()->active)?request()->active:1);
           })
            ->where('active',isset(request()->active)?request()->active:1)
            
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

    public function show($id)
    {
        $restaurant = Restaurant::where('id', $id)->whereHas('visited_restaurant', function ($q) {
            return $q->where('employee_id', Auth::user()->userable_id);
        })->first();
        if ($restaurant)
            return response()->json([
                'success' => true,
                'data' => new RestaurantResource($restaurant),

            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Restaurant Not Found',
            ]);
    }
    public function store(EmployeeRestaurantRequest $request)
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


    public function update(RestaurantUpdateRequest $request, $id)
    {
        $employee = Auth::user()->userable;
        $restaurant = Restaurant::whereHas('visited_restaurant', function ($q) use ($employee) {
            $q->where('employee_id', $employee->id);
        })->where('id', $id)->first();
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
    public function destroy($id)
    {
         
       $restaurant =  Restaurant::whereHas('visited_restaurant', function ($q)  {
            $q->where('employee_id', Auth::user()->userable_id);
        })->where('id', $id)->first();

          
        if($restaurant){ 
            $restaurant->visited_restaurant->delete();
            return response()->json([
                "success" => true,
                "message" => "Restaurant deleted successfully."
            ]);
        }else{
            return response()->json([
                "success" => false,
                "message" => "Restaurant Not Found."
            ]);
        }

       
    }
}
