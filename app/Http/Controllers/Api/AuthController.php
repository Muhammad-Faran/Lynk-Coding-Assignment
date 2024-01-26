<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Api\LoginRequest;
use App\Http\Requests\Auth\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach(2); // Attaching Customer Role

        return $this->SendResponse($user, 'Registered');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $user = Auth::attempt($credentials);
        if (!$user) {
            return response()->json([
                'message' => 'Invalid Credentials!',
            ], 401);
        }
        
        $user = Auth::user();
        // $user['permissions'] = $user->roles[0]->permissions()->pluck('name')->toArray();

        return $this->SendResponse($user, 'Logged In');
    }

    public function logout()
    {
        request()->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'You have Been Logged Out Successfully!',
        ]);
    }

    private function SendResponse($user, $message)
    {
        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'message' => "You have Been $message Successfully!",
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'Bearer',
            ],
        ]);
    }
}
