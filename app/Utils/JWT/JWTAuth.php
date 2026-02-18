<?php

namespace App\Utils\JWT;

use App\Exceptions\DomainException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth
{
    public static function encode(JWTClaims $claims): string
    {
        $secretKey = config('jwt.secret');
        $issuer = config('jwt.issuer');
        $expiration = config('jwt.exp');

        $issuedAt = time();
        $expirationTime = $issuedAt + (int)$expiration;

        $payload = [
            'iat' => $issuedAt,
            'iss' => $issuer,
            'exp' => $expirationTime,
            'sub' => $claims->id,
            'claims' => [
                'email' => $claims->email,
                'username' => $claims->username,
                'roles' => $claims->roles,
                'permissions' => $claims->permissions,
            ],
        ];

        return JWT::encode($payload, $secretKey, 'HS256');
    }

    public static function decode(string $jwt): JWTClaims
    {
        try {
            $secretKey = config('jwt.secret');
            $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));
            return JWTClaims::fromArray(
                (array) $decoded->claims,
                $decoded->sub
            );
        } catch (ExpiredException $e) {
            throw new DomainException("Your session has expired. Please login again.", 401);
        } catch (\Exception $e) {
            throw new DomainException("Invalid or tampered token.", 401);
        }
    }

    public static function encodeRefreshToken(string $subject): string
    {
        $secretKey = config('jwt.secret_refresh');
        $expiration = (int) config('jwt.refresh_exp');
        $issuedAt = time();
        $expirationTime = $issuedAt + ($expiration * 24 * 60 * 60);
        $payload = array(
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'sub' => $subject,
        );
        return JWT::encode($payload, $secretKey, 'HS256');
    }

    public static function decodeRefreshToken(string $jwt): string
    {
        try {
            $secretKey = config('jwt.secret_refresh');
            $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));
            return $decoded->sub;
        } catch (ExpiredException $e) {
            throw new DomainException("Your session has expired. Please login again.", 401);
        } catch (\Exception $e) {
            throw new DomainException("Invalid or tampered token.", 401);
        }
    }
}
