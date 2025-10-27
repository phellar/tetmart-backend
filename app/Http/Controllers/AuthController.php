<?php

namespace App\Http\Controllers;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
     //User Login Handler
     public function login (Request $request):JsonResponse
     {
        $request->validate([
            'email'=>'required|email|max:255',
            'password' =>  'required|string|min:8|max:255',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || ! Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Invalid Login Credentials'
                ], 401);
        }

        $token = $user->createToken($user->name . 'Auth-Token')->plainTextToken;
        return response()->json([
            'message' => 'Login Successful',
            'Token_type' => 'Bearer',
            'Token' => $token
            ], 200);
     } 

     
     // Register user handler
     public function register (Request $request):JsonResponse{

        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken($user->name . 'Auth-Token')->plainTextToken;

        return response()->json([
            'message' => 'Account Created Sucessfully',
            'Token_type' => 'Bearer',
            'Token' => $token
            ], 201);
     }  


    //  Profile handler logic
     public function profile(Request $request){
            
        $user = $request->user();

            return response()->json([
                'message'=> 'profile retrived successfully',
                'status'=> true,
                'data'=> new ProfileResource($user) 
            ],200);
     }


    //  log out handler
    public function logout (Request $request)
    {
        $user = User::where('id', $request->id)->first();
        
        if($user){
            $user->tokens()->delete();
            
            return response()->json([
                'message' => 'user logged out'
                ], 200);
        }
    }

}

