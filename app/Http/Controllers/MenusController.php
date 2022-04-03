<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MenuCategories;

class MenusController extends Controller
{
    //
    public function index()
    {
        $data = MenuCategories::with('menu.submenu.submenu')->get();
        return response()->json($data);
    }
}
