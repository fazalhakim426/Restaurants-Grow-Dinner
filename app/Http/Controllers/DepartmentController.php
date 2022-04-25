<?php
namespace App\Http\Controllers; 
use App\City; 
use App\Department; 
use App\Http\Requests\DepartmentRequest;
use App\Http\Requests\DepartmentUpdateRequest; 
use App\Http\Resources\DepartmentResource; 
class DepartmentController extends Controller
{
    public function index(City $city)
    {
        return response()->json([
            'success' => true,
            'message' => $city->name . ' dapartments List',
            'data'    => DepartmentResource::collection($city->departments),
        ]);
    }

    public function store(DepartmentRequest $request)
    {
        $data = $request->all();
        $country =  Department::create($data);

        return response()->json([
            "success" => true,
            "message" => "Department created successfully.",
            "data" => new DepartmentResource($country),
        ], 200);
    }

    public function update(DepartmentUpdateRequest $request, $id)
    {
        $department = Department::find($id);
        if ($department && $department->update($request->all())) {
            return response()->json([
                "success" => true,
                "message" => "Department updated successfully.",
                "data"    => new DepartmentResource($department),
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Department Not Found.",
            ], 404);
        }
    }
    public function destroy($id)
    {
        $city = Department::find($id);
        if ($city) {
            $city->delete();
            return response()->json([
                "success" => true,
                "message" => "Department deleted successfully."
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Department Not Found."
            ]);
        }
    }
}
