<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\CustomerRequest; 
use App\Http\Resources\CustomerResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{  
    public function index()
    {
        $customer = Customer::all();     
        return response()->json([
            "success" => true,
            "message" => "Customer List",
            "data" =>  CustomerResource::collection($customer)
        ]);
    }

    public function store(CustomerRequest $request)
    {
        $data = $request->all();
  
        $customer = Customer::create($data);
        $data['userable_type']='App\Customer';
        $data['userable_id'] = $customer->id;
        $data['password'] = Hash::make($request->password);

         $customer->user()->save(User::create($data));

        return response()->json([
            "success" => true,
            "message" => "Customer created successfully.",
            "data" => new CustomerResource($customer), 
        ]);
    }

    public function update(Request $request, Customer $customer)
    { 
        $customer->update($request->all()); 
        
        $user = $customer->user;
        $request->validate([ 
            'email' =>'email|unique:users,email,'.$user->id,  
            'phone' =>'min:11|max:14|unique:users,phone,'.$user->id,  
        ]);
        $user->update($request->all());
        if($request->password){ 
            $user->update(['password' => Hash::make($request->password)]);
        }
          $customer->refresh();  
        return response()->json([
            "success" => true,
            "message" => "Student updated successfully.",
            "data" =>new CustomerResource($customer)
        ]);
 
    }

    public function show($id)
    {
     
        $customer = Customer::find($id);
             
        if (is_null($customer)) {
            return response()->json([
                "success" => false,
                "message" => "Customer not Found!"
            ],401);
        }
        return response()->json([
            "success" => true,
            "message" => "Customer retrieved successfully.",
            "data" => new CustomerResource($customer)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        $customer = Customer::find($id);
        if($customer){
            $customer->user->delete();
            $customer->delete();
            return response()->json([
                "success" => true,
                "message" => "Customer deleted successfully."
            ]);
        }else{
            return response()->json([
                "success" => false,
                "message" => "Customer not found."
            ]);
        }

       
    }
}
