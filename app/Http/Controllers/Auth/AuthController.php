<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register (RegisterRequest $request)
    {
        try {

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => \Hash::make($request->input('password')),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'response' => 'success',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ],
                'error' => null
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'response' => 'error',
                'data' => null,
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function login (LoginRequest $request)
    {
        try {

            $credentials = $request->only('email', 'password');

            try {

                if(!$token = JWTAuth::attempt($credentials)){
                    return response()->json([
                        'response' => 'error',
                        'data' => null,
                        'error' => 'Credenciales no validas.'
                    ], 401);
                }

            } catch (JWTException $JWTException) {
                return response()->json([
                    'response' => 'error',
                    'data' => null,
                    'error' => $JWTException->getMessage()
                ], 500);
            }


            return response()->json([
                'response' => 'success',
                'data' => [
                    'token' => $token
                ],
                'error' => null
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'response' => 'error',
                'data' => null,
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function me ()
    {
        try {

            $user = Auth::user()->select('name', 'email')->first();

            return response()->json([
                'response' => 'success',
                'data' => [
                    'user' => $user,
                ],
                'error' => null
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'response' => 'error',
                'data' => null,
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function logout ()
    {
        try {

            JWTAuth::invalidate();

            return response()->json([
                'response' => 'success',
                'data' => [
                    'message' => 'Successfully logged out ',
                ],
                'error' => null
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'response' => 'error',
                'data' => null,
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
