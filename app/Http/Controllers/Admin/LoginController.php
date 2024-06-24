<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    
    public function login(Request $request)
    {
        // return Hash::make($request['password']); 
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        $user = User::where("email","=",$request["email"])->first();
        if(Hash::check($request['password'], $user->password)){
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
