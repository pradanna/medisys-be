<?php

namespace App\DTOs\Auth\Login;

class LoginResponseSchema
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly string $refreshToken
    ) {}
}
