<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\Login\LoginResource;
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
        return APIResponse::success(
            new LoginResource($response),
            "successfully login",
            200
        );
    }
}
