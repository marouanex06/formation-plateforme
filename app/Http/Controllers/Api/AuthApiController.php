<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Identifiants incorrects.'
            ], 401);
        }

        /** @var \App\Models\User $user */
        $user  = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => $user,
        ]);
    }

    public function logout(Request $request)
{
    /** @var \App\Models\User $user */
    $user = $request->user();
    
    /** @var \Laravel\Sanctum\PersonalAccessToken $token */
    $token = $user->currentAccessToken();
    $token->delete();

    return response()->json([
        'message' => 'Déconnecté avec succès.'
    ]);
}

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}