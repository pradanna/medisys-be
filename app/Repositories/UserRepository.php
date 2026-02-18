<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)
            ->where('is_active', true)
            ->first();
    }
}
