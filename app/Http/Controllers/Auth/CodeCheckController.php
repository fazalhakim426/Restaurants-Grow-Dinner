<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\ResetCodePassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CodeCheckController extends Controller
{
    
    public function index(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:reset_code_passwords', 
        ]);
        if(!$request->password){
             return response()->json([
                 'success' => true,
                 'message' => 'Code is valid!'
             ]);
        }
         $request->validate([ 
            'password' => 'string|min:6|confirmed',
        ]);
        // find the code
        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);

        // check if it does not expired: the time is one hour
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return response(['message' => trans('passwords.code_is_expire')], 422);
        }

     
    
        // find user's email 
        $user = User::firstWhere('email', $passwordReset->email);

        // update user password
        $user->update(['password'=> Hash::make($request->password)]);

        // delete current code 
        $passwordReset->delete();

        return response(['message' =>'password has been successfully reset'], 200);
    }
}
