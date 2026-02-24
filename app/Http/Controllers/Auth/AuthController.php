<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Http\Resources\Auth\Login\LoginResource;
use App\Http\Resources\Auth\RefreshToken\RefreshTokenResource;
use App\Services\Auth\AuthService;
use App\Utils\Http\APIResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $service
    ) {}

    public function login(LoginRequest $request)
    {
        $schema = $request->toSchema();
        $response = $this->service->login($schema);
        $expiration = config('jwt.refresh_exp');
        $cookie = cookie(
            'refresh_token',
            $response->refreshToken,
            $expiration * 24 * 60,
            '/',
            null,
            config('app.env') !== 'local',
            true,
            false,
            'Lax'
        );
        return APIResponse::success(
            new LoginResource($response),
            "successfully login",
            200
        )->withCookie($cookie);
    }

    public function refreshToken(Request $request)
    {
        $refreshToken = $request->cookie('refresh_token');
        if (!$refreshToken) {
            return APIResponse::error("missing refresh token", 401);
        }
        $response = $this->service->refreshToken($refreshToken);
        return APIResponse::success(
            new RefreshTokenResource($response),
            "successfully refresh token",
            200
        );
    }
}
