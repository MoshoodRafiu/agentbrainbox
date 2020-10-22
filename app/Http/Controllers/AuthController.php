<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'same:password'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['name', 'email', 'phone', 'country', 'state', 'city', 'address']);
        $data['password'] = Hash::make($request->password);

        $user = new User($data);

        if($user->save()){
            $token = $user->createToken('agent-brain-box-token')->plainTextToken;
            return response()->json(['success' => true, 'data' => ['user' => $user, 'token' => $token]], 200);
        }
        return response()->json(['success' => false, 'errors' => 'Error registering user'], 400);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['success' => false, 'errors' => 'Invalid login credentials'], 400);
        }

        $token = $user->createToken('agent-brain-box-token')->plainTextToken;
        return response()->json(['success' => true, 'data' => ['user' => $user, 'token' => $token]], 200);
    }

    public function logout()
    {
        $user = request()->user();

        $user->tokens()
            ->where('id', $user->currentAccessToken()->id)
            ->delete();

        return response()->json(['success' => true, 'message' => 'User logged out']);
    }
}
