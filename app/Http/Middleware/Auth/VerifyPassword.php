<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class VerifyPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = JWTAuth::user();

        if(!$request->password) return response()->json([ 'message' => 'Password required'], 422);

        if(!Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Contraseña incorrecta',
            ], 401);
        }

        return $next($request);
    }
}
