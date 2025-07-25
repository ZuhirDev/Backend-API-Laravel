<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class Verify2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = JWTAuth::user();
        $payload = JWTAuth::getPayload(JWTAuth::getToken());

        if(!$user || ($user->google2fa_secret && $payload->get('two_factor_verified') !== true)){
            return response()->json([
                'message' => __('auth.2fa.two_factor_authentication_required'),
            ], 401);
        }

        return $next($request);
    }
}
