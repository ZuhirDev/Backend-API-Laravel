<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Registers a new user with email and password.
     * Returns the created user data in the response.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request) 
    {
        $user = $this->userService->createUserService($request->validated());

        return response()->json([
            "message" =>  __('auth.registration_successful', ['name' => $user->name]),
            "data" => $user,
        ], 201);
    }

    /**
     * Authenticates a user using email and password.
     * Returns a token if successful, otherwise an error message.
     * If 2FA is enabled, returns a message requiring 2FA verification.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $token = JWTAuth::attempt($request->only(['email', 'password']));

        if(!$token){
            return response()->json([
                "status" => false,
                "message" => __('auth.invalid_credentials'),
            ], 401);
        }

        $user = JWTAuth::user();

        $cookie = cookie(
            'token',
            $token,
            60,
            '/',
            null,
            false,
            true,
            false,
            'Lax'
        );

        return response()->json([
            "message" => __('auth.login_successful', ['name' => $user->name]), 
            "user" => $user,
        ], 200)->withCookie($cookie);
    }

    /**
     * Logs out the currently authenticated user.
     * Invalidates the JWT token and disables 2FA.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        $cookie = Cookie::forget('token');

        return response()->json([
            "message" => __('auth.logout_successful'),
        ], 200)->withCookie($cookie);
    }

    /**
     * Returns the authenticated user's information.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $user = JWTAuth::user();

        $need2FA = $user->google2fa_secret && (!JWTAuth::payload(JWTAuth::getToken())->get('two_factor_verified') === true);

        return response()->json([
            "message" => __('auth.user_info_retrieved'),
            "user" => $user,
            'need_verify_2fa' => $need2FA,
        ], 200);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $this->userService->updateUserService($request->validated());

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user,
        ]);
    }
}
