<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAuthRequest;
use Illuminate\Support\Facades\Auth;

class UserAuthController {

    public function login(UserAuthRequest $request){
        $credentials = $request->only(['email', 'password']);
        if(!Auth::attempt($credentials)){
            return Response()->json([
                "message" => "Usuário não autorizado.",
                "errors" => [
                    "email" => ["Credenciais inválidas."]
                ]
            ], Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
        }
        $user = auth()->user();
        $token = auth()->user()->createToken('auth_token');
        return response()->json(
            [
                "data" => [
                'token' => $token->plainTextToken,
                'user' => [
                    'name' => $user->name,
                ],
            ]
        ]);
    }

}
