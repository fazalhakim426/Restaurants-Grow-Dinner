<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Requests\CountryRequest; 
use App\Http\Resources\CountryResource;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Country List',
            'data' => CountryResource::collection(Country::all()),
        ]);
    }

    public function store(CountryRequest $request){
        $data = $request->all(); 
         $country =  Country::create($data);
       
         return response()->json([
            "success" => true,
            "message" => "Country created successfully.",
            "data" => $country, 
        ], 201);
    } 

    public function update(CountryRequest $request ,$id)
    {
        $country = Country::find($id);
        if($country && $country->update($request->all())){
            return response()->json([
                "success" => true,
                "message" => "Country updated successfully.",
                "data" => $country, 
            ], 201);
        }
        else{
            return response()->json([
                "success" => false,
                "message" => "Country Not Found.", 
            ], 404);
        }
    }
    public function destroy($id)
    {
        $country = Country::find($id);
        if($country){ 
            $country->delete();
            return response()->json([
                "success" => true,
                "message" => "Country deleted successfully."
            ]);
        }else{
            return response()->json([
                "success" => false,
                "message" => "Country Not Found."
            ]);
        }

       
    }
 
}
