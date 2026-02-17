<?php

namespace App\Models;

use App\Traits\Uuid;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends SpatiePermission
{
    use HasFactory, Uuid;

    protected $keyType = 'string';
    public $incrementing = false;
}
