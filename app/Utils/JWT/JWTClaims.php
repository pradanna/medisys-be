<?php

namespace App\Utils\JWT;

class JWTClaims
{
    /**
     * Menggunakan Constructor Promotion & Readonly
     * Properti otomatis didefinisikan dan diisi.
     */
    public function __construct(
        public readonly mixed $id,
        public readonly string $email,
        public readonly string $username,
        public readonly array $roles,
        public readonly array $permissions = [],
    ) {}

    /**
     * Static helper untuk mapping data dari JWT payload
     */
    public static function fromArray(array $data, mixed $sub): self
    {
        return new self(
            id: $sub,
            email: $data['email'] ?? '',
            username: $data['username'] ?? '',
            roles: $data['roles'] ?? [],
            permissions: $data['permissions'] ?? []
        );
    }
}
