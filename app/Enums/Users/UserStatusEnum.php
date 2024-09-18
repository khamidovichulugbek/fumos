<?php

namespace App\Enums\Users;

enum UserStatusEnum: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;
}
