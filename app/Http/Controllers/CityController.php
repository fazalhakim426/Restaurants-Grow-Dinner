<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Http\Requests\CityRequest;
use App\Http\Requests\CityUpdateRequest;
use App\Http\Resources\CityResource;

class CityController extends Controller
{
    public function index(Country $country)
    {
        return response()->json([
            'success' => true,
            'message' => $country->name . ' Cities List',
            'data'    => CityResource::collection($country->cities),
        ]);
    } 
    public function store(CityRequest $request)
    {
        $data = $request->all();
        $country =  City::create($data);

        return response()->json([
            "success" => true,
            "message" => "City created successfully.",
            "data"    => $country,
        ]);
    } 
    public function update(CityUpdateRequest $request, $id)
    {
        $city = City::find($id);
        if ($city && $city->update($request->all())) {
            return response()->json([
                "success" => true,
                "message" => "City updated successfully.",
                "data"    => $city,
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "City Not Found.",
            ], 404);
        }
    }
    public function destroy($id)
    {
        $city = City::find($id);
        if ($city) {
            $city->delete();
            return response()->json([
                "success" => true,
                "message" => "City deleted successfully."
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "City Not Found."
            ]);
        }
    }
}
