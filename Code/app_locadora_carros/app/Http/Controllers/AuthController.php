<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request) {
        // Autenticar o usuário e retornar um Json Web Token

        $credenciais = $request->all(['email', 'password']);

        $token = auth('api')->attempt($credenciais);

        if($token) {
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['erro' => 'Usuario ou senha invalido'], 403);
        }

    }


    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    public function refresh() {
        //$token = auth('api')->refresh();
        return $this->respondWithToken(auth()->refresh());
    }


    public function me() {
        return response()->json(auth()->user());
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
