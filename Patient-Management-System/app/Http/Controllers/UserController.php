<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{



    // register method
    public function register(Request $request)
    { {
            $validate = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email|unique:users,email",
                "password" => "required",

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
            return response()->json(['status' => true, 'message' => 'User created', 'data' => ['user' => $data]], 200);
        }
    }

    // login method
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "email" => "required|email",
            'password' => ['required', 'string', 'min:8', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/']
        ]);
        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'validation error in login', 'data' => $validate->errors()]);
        }
        try {
            //code...

            if (Auth::attempt($request->all())) {
                $user = Auth::user();
                $token = $user->createToken('data')->accessToken;
                return response()->json(['status' => true, 'message' => 'login succsecfully', 'data' => ['user' => Auth::user()->name, 'access_token' => $token]], 200);
            } else {
                return response()->json(['status' => true, 'message' => 'you have entered either the Email and/or Password incorrectly',]);
            }
        } catch (Exception $exception) {
            return response()->json(["status" => false, "message" => $exception->getMessage()]);
        }
    }
}
