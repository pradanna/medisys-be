<?php

namespace App\Http\Resources\Auth\Login;

use App\DTOs\Auth\Login\LoginResponseSchema;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /** @var LoginResponseSchema $resource */
    public $resource;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->resource->accessToken,
            'refresh_token' => $this->resource->refreshToken
        ];
    }
}
