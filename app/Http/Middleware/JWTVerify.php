<?php

namespace App\Http\Middleware;

use App\Exceptions\DomainException;
use App\Utils\JWT\JWTAuth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JWTVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token) {
            throw new DomainException("Authorization token not provided.", 401);
        }

        $claims = JWTAuth::decode($token);
        $request->attributes->add(['auth_claims' => $claims]);
        return $next($request);
    }
}
