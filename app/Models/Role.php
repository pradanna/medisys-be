<?php

namespace App\Models;

use App\Traits\Uuid;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends SpatieRole
{
    use HasFactory, Uuid;

    protected $keyType = 'string';
    public $incrementing = false;
}
