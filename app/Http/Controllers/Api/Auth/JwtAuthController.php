<?php

namespace App\Http\Controllers\Api\Auth;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtAuthController extends Controller
{
    use ApiResponseTrait;

    public function register(Request $request)
    {
        
       $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationErrorResponse($validator->messages(), 'Error');
        }

        $user = User::create([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role_id' => 3,
            'status' => 1
        ]);
       
        $token = JWTAuth::fromUser($user);
        $payload = JWTAuth::setToken($token)->getPayload();
        $user_data = JWTAuth::toUser($token);
        return $this->sendSuccessResponse($this->respondWithUserToken($token, $user_data), 'Registration success');
      
    }

    // User login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationErrorResponse($validator->messages(), 'Error');
        }
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1,
            'role_id' => 3
        ];

        if (! $token = auth('api')->attempt($credentials)) {
            return $this->sendNotFoundResponse(null,'Provided credentials does not match our records');
        }

        return $this->sendSuccessResponse($this->respondWithToken($token), 'Login success');
    }

    public function profile()
    {
        $user = $this->guard()->user();
        return $this->sendSuccessResponse($user, 'Success');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->sendSuccessResponse($this->respondWithToken($this->guard()->refresh()), 'Success');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
   
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'me' => $this->guard()->user(),
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    protected function respondWithUserToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'me' => $user,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}
