<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserActivity;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('jwt.verify', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request){
    	$validator = $request->validated();

        if (! $token = auth()->attempt($validator)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        UserActivity::create([
            'user_id'       => auth()->user()->id,
            'email'         => auth()->user()->email,
            'activity'      => 'Log In',
            'user_agent'    => request()->header('user-agent'),
            'ip_address'    => request()->ip()
        ]);
        return $this->createNewToken($token);
    }
    
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        UserActivity::create([
            'user_id'       => auth()->user()->id,
            'email'         => auth()->user()->email,
            'activity'      => 'Log Out',
            'user_agent'    => request()->header('user-agent'),
            'ip_address'    => request()->ip()
        ]);

        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'expires_in'    => auth()->factory()->getTTL() * 60,
            'user'          => auth()->user()
        ]);
    }
}
