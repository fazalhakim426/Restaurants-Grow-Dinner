<?php

namespace App\Http\Controllers\Customer;

use App\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
   
    public function index()
    { 
        $auth_user = Auth::user();
        $customer = $auth_user->userable;
        return response()->json([
            'success' => true,
            'message' => $auth_user->first_name .' '.$auth_user->last_name .' Address',
            'data' => AddressResource::collection($customer->addresses),
        ]);
    }

    public function store(AddressRequest $request){
        $data = $request->all(); 
        
        $auth_user = Auth::user();
        $customer = $auth_user->userable; 
        $data['customer_id'] = $customer->id; 
         $address =   Address::create($data); 
         return response()->json([
            "success" => true,
            "message" => "Address save successfully.",
            "data" => new AddressResource($address), 
        ], 200);
    } 

 
    public function update(AddressRequest $request ,$id)
    {        
        $auth_user = Auth::user();
        $customer = $auth_user->userable;
        $address = $customer->addresses->where('id',$id)->first();
        if($address && $address->update($request->all())){
            return response()->json([
                "success" => true,
                "message" => "Address updated successfully.",
                "data" => new AddressResource($address), 
            ]);
        }
        else{
            return response()->json([
                "success" => false,
                "message" => "Address Not Found.", 
            ], 404);
        }
    }
    public function destroy($id)
    {
        
        $auth_user = Auth::user();
        $customer = $auth_user->userable;
        $address = $customer->addresses()->where('id',$id)->first();  
        if($address){ 
            $address->delete();
            return response()->json([
                "success" => true,
                "message" => "Address deleted successfully."
            ]);
        }else{
            return response()->json([
                "success" => false,
                "message" => "Address Not Found."
            ]);
        }

       
    }
 
}
