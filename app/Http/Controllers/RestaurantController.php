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
use Illuminate\Support\Facades\Hash;

class RestaurantController extends Controller
{
    public function index()
    { 
        $auth_user = Auth::user();
        if($auth_user->userable_type=='App\Employee'){ 
            $restaurant = $auth_user->userable->restaurants(); 
        } 
        else{ 
        $restaurant = Restaurant::all();
        }

        return response()->json([
            "success" => true,
            "message" => "Restaurant List",
            "data" =>  RestaurantResource::collection($restaurant)
        ]);
    }

    public function admin_store(RestaurantRequest $request)
    {    
        $data = $request->all();  
        if($request->photo){ 
            $fileName = time().'.'.$request->photo->extension();  
            $request->photo->move(public_path('uploads/restaurant'), $fileName); 
            $data['photo'] = 'uploads/restaurant/'.$fileName;    
        }
        if($request->menu){ 
            $fileName = time().'.'.$request->menu->extension();  
            $request->menu->move(public_path('uploads/restaurant/menu'), $fileName); 
            $data['menu'] = 'uploads/restaurant/'.$fileName;    
        }

        $data['password'] =  Hash::make($request->password);    

        $restaurant = Restaurant::create($data);
        $data['userable_type']='App\Restaurant';
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
        if($request->photo){ 
            $fileName = time().'.'.$request->photo->extension();  
            $request->photo->move(public_path('uploads/restaurant'), $fileName); 
            $data['photo'] = 'uploads/restaurant/'.$fileName;    
        }
        if($request->menu){ 
            $fileName = time().'.'.$request->menu->extension();  
            $request->menu->move(public_path('uploads/restaurant/menu'), $fileName); 
            $data['menu'] = 'uploads/restaurant/'.$fileName;    
        }

        $data['password'] =  Hash::make($request->password);    

        $restaurant = Restaurant::create($data);
        $data['userable_type']='App\Restaurant';
        $data['userable_id'] = $restaurant->id;

         $restaurant->user()->save(User::create($data)); 
            
         VisitedRestaurant::create([
            'employee_id' => Auth::user()->userable_id,
            'restaurant_id' =>$restaurant->id,
            'feedback' => $request->feedback,
            'visited_at' =>$request->visited_at
        ]); 

        return response()->json([
            "success" => true,
            "message" => "Restaurant created successfully.",
            "data" => new RestaurantResource($restaurant), 
        ], 201);
    }

    public function update(RestaurantUpdateRequest $request ,$id)
    {  
        $restaurant = Restaurant::find($id);
        if($restaurant){
        $restaurant->update($request->all()); 
        $user = $restaurant->user;
        $user->update($request->all()); 
        if($request->documents){  
            $fileName = time().'.'.$request->documents->extension();  
            $request->documents->move(public_path('uploads/restaurant'),$fileName);  
            $restaurant->update(['documents'=>'uploads/restaurant/'.$fileName]);    
        }
        if($request->password){ 
            $restaurant->user->update(['password' => Hash::make($request->password)]);
        }
        $restaurant->refresh();  
        return response()->json([
            "success" => true,
            "message" => "Updated successfully.",
            "data" =>new RestaurantResource($restaurant)
        ]); 
        }else{
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
            ],401);
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
        if($restaurant){
            $restaurant->user->delete();
            $restaurant->delete();
            return response()->json([
                "success" => true,
                "message" => "Restaurant deleted successfully."
            ]);
        }else{
            return response()->json([
                "success" => false,
                "message" => "Restaurant not found."
            ]);
        }

       
    }
}
