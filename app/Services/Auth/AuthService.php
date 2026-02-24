<?php

namespace App\Services\Auth;

use App\DTOs\Auth\Login\LoginRequestSchema;
use App\DTOs\Auth\Login\LoginResponseSchema;
use App\DTOs\Auth\RefreshToken\RefreshTokenResponseSchema;
use App\Exceptions\DomainException;
use App\Interfaces\UserInterface;
use App\Utils\JWT\JWTAuth;
use App\Utils\JWT\JWTClaims;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private UserInterface $repository
    ) {}

    public function login(LoginRequestSchema $schema): LoginResponseSchema
    {
        $email = $schema->email;
        $user = $this->repository->findByEmail($email);
        if (!$user) {
            throw new DomainException("akun pengguna tidak ditemukan", 404);
        }

        $isPasswordValid = Hash::check($schema->password, $user->password);
        if (!$isPasswordValid) {
            throw new DomainException("password tidak cocok", 401);
        }

        $roles = $user->getRoleNames()->toArray();
        $permissions = $user->getAllPermissions()
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();

        $jwtClaims = new JWTClaims(
            id: $user->id,
            email: $user->email,
            username: $user->email,
            roles: $roles,
            permissions: $permissions
        );

        return new LoginResponseSchema(
            accessToken: JWTAuth::encode($jwtClaims),
            refreshToken: JWTAuth::encodeRefreshToken($user->email),
        );
    }

    public function refreshToken(string $refreshToken): RefreshTokenResponseSchema
    {
        $email = JWTAuth::decodeRefreshToken($refreshToken);
        $user = $this->repository->findByEmail($email);
        if (!$user) {
            throw new DomainException("pengguna tidak ditemukan", 404);
        }

        $roles = $user->getRoleNames()->toArray();
        $permissions = $user->getAllPermissions()
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();

        $jwtClaims = new JWTClaims(
            id: $user->id,
            email: $user->email,
            username: $user->username,
            roles: $roles,
            permissions: $permissions
        );

        return new RefreshTokenResponseSchema(
            accessToken: JWTAuth::encode($jwtClaims)
        );
    }
}
