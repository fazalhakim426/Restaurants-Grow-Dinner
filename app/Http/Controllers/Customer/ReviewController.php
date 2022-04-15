<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Review; 
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller{
 
       
        public function index()
        { 
            $auth_user = Auth::user();
            $customer = $auth_user->userable;
            return response()->json([
                'success' => true,
                'message' => $auth_user->first_name .' '.$auth_user->last_name .' Review',
                'data' => ReviewResource::collection($customer->Reviewes),
            ]);
        }
    
        public function store(ReviewRequest $request){
            $data = $request->all();  
            $auth_user = Auth::user();
            $customer = $auth_user->userable; 
            $data['customer_id'] = $customer->id;  
             $review =   Review::create($data); 
             
             return response()->json([
                "success" => true,
                "message" => "Review save successfully.",
                "data" => new ReviewResource($review), 
            ], 200);
        } 
    
     
        public function update(ReviewRequest $request ,$id)
        {        
            $auth_user = Auth::user();
            $customer = $auth_user->userable;
            $review = $customer->Reviewes->where('id',$id)->first();
            if($review && $review->update($request->all())){
                return response()->json([
                    "success" => true,
                    "message" => "Review updated successfully.",
                    "data" => new ReviewResource($review), 
                ]);
            }
            else{
                return response()->json([
                    "success" => false,
                    "message" => "Review not found!.", 
                ], 404);
            }
        }
        public function destroy($id)
        { 
            $auth_user = Auth::user();
            $customer = $auth_user->userable;
            $review = $customer->Reviewes()->where('id',$id)->first();  
            if($review){ 
                $review->delete();
                return response()->json([
                    "success" => true,
                    "message" => "Review deleted successfully."
                ]);
            }else{
                return response()->json([
                    "success" => false,
                    "message" => "Review not found!."
                ]);
            } 
        }
     
    }