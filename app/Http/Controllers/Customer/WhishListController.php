<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantResource;
use App\WhishList;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WhishListController extends Controller
{
    public function index()
    {
 
        $customer =  Auth::user()->userable;
        $restaurants = $customer->WhishLists;

        return response()->json([
            'success' => true,
            'message' => 'Whish list',
            'data' => RestaurantResource::collection($restaurants)
        ]);

    }
    public function show($id)
    { 
        
        $auth_user = Auth::user();
         $whishlist =  WhishList::where('customer_id',$auth_user->userable_id)->where('restaurant_id',$id)->first();
         if($whishlist){
             $whishlist->delete();
             return response()->json([
                 'success' => true,
                 'message' => 'Disliked!'
             ]);
         }else{
             try{
                   WhishList::create(
                [
                    'customer_id'=>$auth_user->userable_id,
                    'restaurant_id'=>$id
                ]);
             }
             catch(Exception $e){
                   return response()->json([
                       'success' => false,
                       'message' => 'No Restaurant found.'
                   ]);
             }
          
            return response()->json([
                'success' => true,
                'message' => 'Liked!'
            ]);
         }
    }
}
