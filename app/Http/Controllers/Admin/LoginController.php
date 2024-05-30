<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $user = User::where("email","=",$request["email"])
                ->where("password","=",$request["password"])->first();
        if($user){
            return response()->json([
                'status'=>"success",
                'user'=>$user
            ]);
        }
        else{
            return response()->json([
                'status'=>"Error",
            ]);
        }
        
    }

    
}
