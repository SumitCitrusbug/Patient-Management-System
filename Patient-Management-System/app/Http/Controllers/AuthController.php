<?php

namespace App\Http\Controllers;

use App\Jobs\registrationMail;
use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // register method
    public function register(Request $request)
    { //changes add mail on registration


        //validation in registration
        $validate = Validator::make($request->all(), [
            "name" => "required|string|max:20",
            "email" => "required|email|unique:users,email",
            "password" => ['required', 'string', 'min:8', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/'],
        ]);
        if ($validate->fails()) {

            return response()->json(['status' => false, 'message' => 'validation error ', 'data' => $validate->errors()]);
        }
        try {

            $role = Role::where("roles", 'user')->first();
            $data = User::create([
                'id' => Str::uuid(),
                "name" => $request->name,
                "email" => $request->email,
                "password" => bcrypt($request->password),
                "role_id" => $role->id,
            ]);
        } catch (Exception $exception) {
            return response()->json(["status" => false, "message" => $exception->getMessage()]);
        }
        dispatch(new registrationMail($data));
        return response()->json(['status' => true, 'message' => 'User created', 'data' => ['user' => $data]], 200);
    }

    // login method
    public function login(Request $request)
    {
        //validation in login
        $validate = Validator::make($request->all(), [
            "email" => "required|email",
            'password' => ['required', 'string', 'min:8', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/']
        ]);
        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'validation error in login', 'data' => $validate->errors()]);
        }
        try {
            if (Auth::attempt($request->all())) {
                $user = Auth::user();
                $token = $user->createToken('data')->accessToken;
                return response()->json(['status' => true, 'message' => 'login successfully', 'data' => ['user' => Auth::user()->name, 'access_token' => $token]], 200);
            } else {
                return response()->json(['status' => true, 'message' => 'you have entered either the Email and/or Password incorrectly',]);
            }
        } catch (Exception $exception) {
            return response()->json(["status" => false, "message" => $exception->getMessage()]);
        }
    }
}
