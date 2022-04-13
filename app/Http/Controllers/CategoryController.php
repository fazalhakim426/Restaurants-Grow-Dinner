<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{ 
    
    public function index()
    { 
        return response()->json([
            'success' => true,
            'message' =>'Category List',
            'data' => Category::when(isset(request()->active),function($q){
                         return $q->where('active',request()->active);
                    })->get(),
        ]);
    }

    public function store(CategoryRequest $request){
        $data = $request->all(); 
         $category =  Category::create($data);
       
         return response()->json([
            "success" => true,
            "message" => "Category created successfully.",
            "data" => $category, 
        ]);
    }

 
    public function update(Request $request ,$id)
    {
        $request->validate([
            'name'=>'required|unique:categories,id,'.$id, 

        ]);
        $category = Category::find($id);
        if($category && $category->update($request->all())){
            return response()->json([
                "success" => true,
                "message" => "Category updated successfully.",
                "data" => $category, 
            ], 201);
        }
        else{
            return response()->json([
                "success" => false,
                "message" => "Category Not Found.", 
            ], 404);
        }
    }
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category){ 
            $category->delete();
            return response()->json([
                "success" => true,
                "message" => "Category deleted successfully."
            ]);
        }else{
            return response()->json([
                "success" => false,
                "message" => "Category Not Found."
            ]);
        }

       
    }
}
