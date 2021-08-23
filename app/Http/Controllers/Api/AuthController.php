<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Services\AuthService as AuthService;

class AuthController extends Controller
{
    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    public function login(AuthService $authService)
    {
        try {
            $validator = $authService->validator($this->_request->all());

            if($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()->toArray()
                ],400);
            }
            
            $loginData = request(['email', 'password']);
            if(!auth()->attempt($loginData)) {
                return response()->json([
                    'error' => 'Unauthorised Access'
                ],401);
            } else {
                $user_login_token = auth()->user()->createToken('authToken')->accessToken;
                return response()->json([
                    'access_token' => $user_login_token
                ],200);
            }

        } catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ],401);
        }

    }

    public function user()
    {
        return response()->json(['authenticated-user' => auth()->user()], 200);
    }
}
