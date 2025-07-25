<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PragmaRX\Google2FALaravel\Google2FA;
use Tymon\JWTAuth\Facades\JWTAuth;

class TwoFactorAuthController extends Controller
{
    protected $google2fa;

    public function __construct(Google2FA $google2fa)
    {
        $this->google2fa = $google2fa;
    }
    
    /**
     * Enables 2FA for the authenticated user.
     * Generates a secret key and QR code URL for the user to configure in their authenticator app.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enable2FA(Request $request)
    {
        $user = JWTAuth::user();      

        if($user->google2fa_secret){
            return response()->json(['message' => __('auth.2fa.already_enabled')]);
        }

        $secretKey  = $this->google2fa->generateSecretKey();

        User::find($user->id)->update([
            'google2fa_secret' => $secretKey,
            'google2fa_enabled' => true,
        ]);

        $qrCodeURL = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secretKey,
        );

        return response()->json([
            'message' => __('auth.2fa.enabled_successfully'),
            'secret' => $secretKey,
            'qr_url' => $qrCodeURL,
        ]); 
    }

    /**
     * Verifies the 2FA code and enables 2FA on the user's account.
     * Invalidates the old JWT and returns a new one.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify2FA(Request $request)  
    {
        $request->validate([
            'one_time_password' => 'required|string|digits:6',
        ]);

        if(JWTAuth::payload(JWTAuth::getToken())->get('two_factor_verified') === true) return response()->json(['message' => __('auth.2fa.already_enabled')]);
        
        $user = JWTAuth::user();
        
        if(!$user->google2fa_secret) return response()->json(['message' => __('auth.2fa.not_enabled')]); 

        $valid = $this->google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if(!$valid) return response()->json(['message' => __('auth.2fa.invalid_code')], 400);

        JWTAuth::invalidate(JWTAuth::getToken());

        $customClaims = [
            'two_factor_verified' => true,
        ];

        $token = JWTAuth::claims($customClaims)->fromUser($user);

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
            'message' => __('auth.2fa.verified_successfully'),
        ], 200)->withCookie($cookie);
    }

    /**
     * Disables 2FA for the authenticated user.
     * Removes the secret and disables the flag.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */    
    public function disable2FA(Request $request)
    {
        $user = JWTAuth::user();

        if(!$user->google2fa_secret) return response()->json(['message' => __('auth.2fa.already_disabled')], 422);

        $user->google2fa_secret = null;
        $user->google2fa_enabled = false;
        $user->save();

        JWTAuth::invalidate(JWTAuth::getToken());

        $token = JWTAuth::fromUser($user);

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

        return response()->json(['message' => __('auth.2fa.disabled_successfully')], 200)->withCookie($cookie);
    }
}
