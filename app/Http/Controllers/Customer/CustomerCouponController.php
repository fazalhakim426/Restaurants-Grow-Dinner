<?php

namespace App\Http\Controllers\Customer;

use App\Coupon;
use App\CustomerCoupon;
use App\Http\Controllers\Controller; 
use App\Http\Requests\CustomerCouponRequest;
use App\Http\Resources\CouponResource;
use App\Http\Resources\CustomerCouponResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerCouponController extends Controller
{
    public function index()
    {
        if(isset(request()->active))
        $coupens = Auth::user()->userable->customer_coupons()->where('active',true)->get();
        else
        $coupens = Auth::user()->userable->customer_coupons()->whereHas('coupon',function($q){
            $q->where('active',false);
        })->get();

 
        // $coupens = CustomerCoupon::all();
        return response()->json([
            'success' => true,
            'data' => CustomerCouponResource::collection($coupens),

        ]);
    }
     public function store(CustomerCouponRequest $request)
     {
         $coupon = Coupon::find($request->coupon_id);
     
         if(!$coupon->active){
             return response()->json([
                 'success' => true,
                 'errors' => $coupon->expired?'Coupen is Expired!':'Coupon is not active yet!.',
                    'coupon_id' => [
                                ['coupon id invalid!'],
                    ] 
                 ],401);
         }
        $coupen = CustomerCoupon::create([
            'customer_id' => Auth::user()->userable_id,
            'coupon_id' => $request->coupon_id,
        ]);

        if($coupen){
           return response()->json([
               'success' => true,
               'message' => 'Coupen Added',
               'data' =>new CouponResource($coupon)
           ]);
        }

     }
     public function destroy($id)
     {
         $customer_coupon = CustomerCoupon::find($id);
        if($customer_coupon){
            $customer_coupon->delete();
            return response()->json([
                'success' => true,
                'message' => 'Deleted Successfully!'
            ]);
        }
     }
}
