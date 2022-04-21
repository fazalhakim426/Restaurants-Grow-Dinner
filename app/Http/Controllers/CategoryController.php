<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Category List',
            'data'    => CategoryResource::collection(
                    Category::when(isset(request()->active), function ($q) {
                        return $q->where('active', request()->active);
                    })->get()
                ),
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        if ($request->icon) {
            $fileName = time() . '.' . $request->icon->extension();
            $request->icon->move(public_path('uploads/restaurant/tables'), $fileName);
            $data['icon'] = 'uploads/category/icon/' . $fileName;
        }
        $category =  Category::create($data);
        return response()->json([
            "success" => true,
            "message" => "Category Created successfully.",
            "data"    => new CategoryResource($category),
        ]);
    }

    public function update(Request $request, $id)
    {
        $data =  $request->validate([
            'name' => 'required|unique:categories,id,' . $id,
        ]);

        if ($request->icon) {
            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads/restaurant/tables'), $fileName);
            $data['icon'] = 'uploads/category/icon/' . $fileName;
        }

        $category = Category::find($id);
        if ($category && $category->update($data)) {
            return response()->json([
                "success" => true,
                "message" => "Category updated successfully.",
                "data"    => new CategoryResource($category),
            ], 201);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Category Not Found.",
            ], 404);
        }
    }
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json([
                "success" => true,
                "message" => "Category deleted successfully."
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Category Not Found."
            ]);
        }
    }
}
