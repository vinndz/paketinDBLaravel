<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    public function index()
    {
        $users = User::all();

        if(count($users) > 0){
        return response([
                'message' => 'Retrieve All Success',
                'data' => $users
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($id)
    {
        $user = Profile::find($id);
        if(!is_null($user)){
            return response([
                'message' => 'Retrieve User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ],404);
    }


    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'username' => 'required',
            'password' => 'required',
            'email' => 'required',
            'phonenumber' => 'required|numeric',
            'birthdate' => 'required'
        ]);

        if($validate->fails()) //Untuk mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);

        $user = Profile::create($storeData);
        return response([
            'message' => 'Add user Success',
            'data' => $user
        ],200);
    }


    public function update(Request $request, $id)
    {
        $user = Profile::find($id);

        if(is_null($user)){
            return response([
                'message' => 'user Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'username' => 'required',
            'password' => 'required',
            'email' => 'required',
            'phonenumber' => 'required|numeric',
            'birthdate' => 'required'
        ]);

        if($validate->fails()) //Untuk mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);

        $user->username = $updateData['username'];
        $user->password = $updateData['password'];
        $user->email = $updateData['email'];
        $user->phonenumber = $updateData['phonenumber'];
        $user->birthdate = $updateData['birthdate'];

        if($user->save()){
             return response([
                'message'=> 'Update user Success',
                'data' => $user
             ], 200);
        }

        return response([
            'message'=> 'Update user Failed',
            'data' => null
        ], 400);
    }

}
