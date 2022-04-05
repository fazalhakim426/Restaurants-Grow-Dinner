<?php

namespace App\Http\Controllers;

use App\Finance; 
use App\Http\Requests\FinanceRequest;
use App\Http\Requests\FinanceUpdateRequest;
use App\Http\Resources\FinanceResource;
use App\User;
use Illuminate\Support\Facades\Hash;

class FinanceController extends Controller
{
    //

    public function index()
    {
        $finance = Finance::all();

        return response()->json([
            "success" => true,
            "message" => "Finance List",
            "data" =>  FinanceResource::collection($finance)
        ]);
    }

    public function store(FinanceRequest $request)
    {
        $data = $request->all();
  
        $finance = Finance::create($data);
        $data['userable_type']='App\Finance';
        $data['userable_id'] = $finance->id;

         $finance->user()->save(User::create($data));

        return response()->json([
            "success" => true,
            "message" => "Finance created successfully.",
            "data" => new FinanceResource($finance), 
        ], 201);
    }

    public function update(FinanceUpdateRequest $request, Finance $finance)
    { 
        $finance->update($request->all()); 
        $user = $finance->user;
        $user->update($request->all());
        if($request->password){ 
            $user->update(['password' => Hash::make($request->password)]);
        }

        $finance->refresh();  
        return response()->json([
            "success" => true,
            "message" => "Updated successfully.",
            "data" =>new FinanceResource($finance)
        ]);
 
    }

    public function show($id)
    {
     
        $finance = Finance::find($id);
             
        if (is_null($finance)) {
            return response()->json([
                "success" => false,
                "message" => "Finance not Found!"
            ],401);
        }
        return response()->json([
            "success" => true,
            "message" => "Finance retrieved successfully.",
            "data" => new FinanceResource($finance)
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

        $finance = Finance::find($id);
        if($finance){
            $finance->user->delete();
            $finance->delete();
            return response()->json([
                "success" => true,
                "message" => "Finance deleted successfully."
            ]);
        }else{
            return response()->json([
                "success" => false,
                "message" => "Finance not found."
            ]);
        }

       
    }
}
