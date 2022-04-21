<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Http\Requests\CouponRequest;
use App\Http\Resources\CouponResource; 
class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => CouponResource::collection(Coupon::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request)
    {
        $data = $request->all();
        $coupon =  Coupon::create($data);
        return response()->json([
            'success' => true,
            'message' => 'Coupon created',
            'data'    => new CouponResource($coupon),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponRequest $request, Coupon $coupon)
    {
        $coupon = $coupon->update($request->all());
        if ($coupon) {
            return response()->json([
                'success' => true,
                'message' => 'Coupon Updated Successfully!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        if ($coupon->delete())
            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully.'
            ]);
        else
            return response()->json([
                'success' => true,
                'message' => 'Coupon Not Found.'
            ]);
    }
}
