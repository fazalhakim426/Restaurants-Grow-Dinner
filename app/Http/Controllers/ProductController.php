<?php

namespace App\Http\Controllers;
use App\Product;
// use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $userList = Product::paginate(20);
        return response()->json($userList, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        $data = $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'name'     => ['required', 'string'],
            'price'    => 'required',
            'manufacture_name' => 'required',
            'manufacture_brand' => 'required',
        ]);

        $avataruloaded = request()->file('image');
        $avatarname = time() . '.' . $avataruloaded->getClientOriginalExtension();
        $avatarpath = public_path('/images/');
        $avataruloaded->move($avatarpath, $avatarname);
        $data['image'] =  '/images/' . $avatarname;

        $user = Product::create($data);
        return response()->json($user, 201);
    }

    public function prices()
    {
        $prices = [];

        foreach (Product::PRICES as $index => $name) {
            $prices[] = [
                'name' => $name,
                'products_count' => $this->getProductCount($index)
            ];
        }

        return $prices;

        return response()->json($prices);
    }
    private function getProductCount($index)
    {
        return Product::withFilters()
            ->when($index == 0, function ($query) {
                $query->where('price', '<', '5000');
            })
            ->when($index == 1, function ($query) {
                $query->whereBetween('price', ['5000', '10000']);
            })
            ->when($index == 2, function ($query) {
                $query->whereBetween('price', ['10000', '50000']);
            })
            ->when($index == 3, function ($query) {
                $query->where('price', '>', '50000');
            })
            ->count();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
