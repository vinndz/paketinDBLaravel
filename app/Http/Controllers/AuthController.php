<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Profile;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        //
        $regisData = $request->all();
        $validate = Validator::make($regisData, [
            'username' => 'required',
            'password' => 'required',
            'email' => 'required',
            'phonenumber' => 'required|numeric',
            'birthdate' => 'required'
        ]);

        if($validate->fails()) 
            return response(['message' => $validate->errors()], 400);

        $profile = Profile::create($regisData);
        return response([
            'message' => 'Add Profile Success',
            'data' => $profile
        ],200);

    }

    public function checkLogin(Request $request){
        $loginData = $request->all();
        
        $validate = Validator::make($loginData, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $isLogin = Profile::where('username', $loginData["username"])->where('password', $loginData['password'])->exists();

        if($isLogin){
            return response([
                'message' => 'Profile Found',
                'data' => Profile::where('username', $loginData["username"])->where("password", $loginData["password"])->first()
            ], 200);
        }

        return response([
            'message' => 'Unauthenticated',
            'data' => null
        ], 400);
    }

}