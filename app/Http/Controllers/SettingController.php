<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Http\Requests\SettingRequest;
use Illuminate\Http\Request; 
class SettingController extends Controller
{

    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Setting List',
            'data'    => Setting::get(),
        ]);
    }

    public function store(SettingRequest $request)
    {
        $data = $request->all();
        $setting =  Setting::create($data);

        return response()->json([
            "success" => true,
            "message" => "Setting created successfully.",
            "data"    => $setting,
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'value' => 'required',

        ]);
        $setting = Setting::find($id);
        if ($setting && $setting->update($request->only('value'))) {
            return response()->json([
                "success" => true,
                "message" => "Setting updated successfully.",
                "data"    => $setting,
            ], 201);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Setting Not Found.",
            ], 404);
        }
    }
    public function destroy($id)
    {
        $setting = Setting::find($id);
        if ($setting) {
            $setting->delete();
            return response()->json([
                "success" => true,
                "message" => "Setting deleted successfully."
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Setting Not Found."
            ]);
        }
    }
}
