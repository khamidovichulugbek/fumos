<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $hidden = [
        'password'
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
