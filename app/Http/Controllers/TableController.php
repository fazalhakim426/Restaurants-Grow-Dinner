<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use App\Http\Requests\TableUpdateRequest;
use App\Http\Resources\RestaurantResource;
use App\Http\Resources\TableResource;
use App\Restaurant;
use App\Table; 
class TableController extends Controller
{
    public function index($id)
    {
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            return response()->json([
                'success' => true,
                'message' => 'Table List!',
                'data' =>  TableResource::collection($restaurant->tables),
                'restaurant'   => new RestaurantResource($restaurant), 


            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Restaurant Not Found!"
            ]);
        }
    }
    public function store(TableRequest $request)
    {
        $data = $request->all();

        if ($request->photo) {
            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads/restaurant/tables'), $fileName);
            $data['photo'] = 'uploads/restaurant/tables/' . $fileName;
        }
        $table =  Table::create($data);
        if ($table) {
            return response()->json([
                'success' => true,
                'message' => "Table Created Successfully",
                'data' => $table,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => ' Fail To create Table!',
            ]);
        }
    }

    public function update(TableUpdateRequest $request, $id)
    {
        $data = $request->all();
        if ($request->restaurant_id) {
            return response()->json([
                'success' => false,
                'message' => "Restaurant can't be change.",
            ]);
        }
        if ($request->photo) {
            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads/restaurant/tables'), $fileName);
            $data['photo'] = 'uploads/restaurant/tables/' . $fileName;
        }

        $table =  Table::find($id);
        if ($table) {
            $table->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Updated Successfully!',
                'data' => $table,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed To  Update!',
            ]);
        }
    }
    public function destroy($id)
    {
        $table = Table::find($id);
        if ($table) {
            $table->delete();
            return response()->json([
                'success' => true,
                'message' => 'Table Deleted Successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Table Not Found!',
            ], 404);
        }
    }
}
