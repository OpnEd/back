<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'card_id' => 'required',
            'card_id_type' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'team_id' => 'nullable'
        ]);

        $user = User::create($data);

        $token = $user->createToken($request->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)){
            return [
                'message' => 'The provided credentials are incorrect :('
            ];
        }

        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
        /* Auth::attempt(['email' => $email, 'password' => $password]); */
    }

    public function logout(Request $request)
    {
         $request->user()->tokens()->delete(); // para borrar todos los tokens en todos los dispositivos
        // $request->user()->currentAccessToken()->delete(); // para borrar solo el token en el dispositivo actual

        return [
            'message' => 'You are logged out!'
        ];

    }
}
