<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin_index($component = "admin_home")
    {

        $user = Auth::user(); 
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token; 
        $access_token = $tokenResult->accessToken; 
        return view('home', compact('component', 'access_token'));
    }
    public function employee_index($component = "employee_home")
    { 
        $user = Auth::user(); 
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token; 
        $access_token = $tokenResult->accessToken; 
        return view('home', compact('component', 'access_token'));
    }

    public function finance_index($component = "finance_home")
    {
        $user = Auth::user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $access_token = $tokenResult->accessToken;
        return view('home', compact('component', 'access_token'));
    }

    public function redirect()
    {

        $role = substr(Auth::user()->userable_type, 4); 
        if ($role == "Admin") {
            return $this->admin_index();
        } else if ($role == "Employee") {
            return $this->employee_index();
        } else if ($role == "Finance") {
            return $this->finance_index();
        } else {
            echo 'You are not allowed!';
        } 
    }

    public function redirect2($group, $component, $id = "")
    {
        $userable = Auth::user()->userable_type;
        return view('home', compact('group', 'component', "id"));
    }

    public function admin_show($group, $component, $id = "")
    {
        return view('home', compact('group', 'component', "id"));
    }
}
