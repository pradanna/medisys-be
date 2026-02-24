<?php

namespace App\DTOs\Auth\RefreshToken;

class RefreshTokenResponseSchema
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $accessToken,
    ) {}
}
