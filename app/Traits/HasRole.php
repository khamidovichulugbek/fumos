<?php

namespace App\Traits;

use App\Enums\Users\RoleEnum;

trait HasRole
{
    public function isAdmin(): bool
    {
        return $this->role_id === RoleEnum::ADMIN->value;
    }
}
