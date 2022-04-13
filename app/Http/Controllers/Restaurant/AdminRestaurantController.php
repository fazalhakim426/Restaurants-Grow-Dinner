<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRequest;
use App\Http\Requests\RestaurantUpdateRequest;
use App\Http\Resources\RestaurantResource;
use App\Restaurant;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminRestaurantController extends Controller
{
  
    public function index()
    {
        $options = json_decode(request()->options);
        $page = $options ? $options->page : 1;
        $itemsPerPage = $options ? $options->itemsPerPage : -1;
        $sortBy = $options ? $options->sortBy : 'id';
        $sortDesc = $options ? $options->sortDesc : 'ASC';
 
        $major_query = $this->employee_major_query();

        $query = $major_query;

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
 
    public function store(RestaurantRequest $request)
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

   
    public function update(RestaurantUpdateRequest $request, $id)
    {
        $request->validate([ 
            'email' => ['unique:users', 'string', 'email'], 
            'phone' => ['unique:users', 'string','min:11','max:14'],
        ]);

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
            if($restaurant->visited_restaurant )
                $restaurant->visited_restaurant->delete();
            else
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
