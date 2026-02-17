<?php

namespace App\DTOs\Auth\Login;

class LoginRequestSchema
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
