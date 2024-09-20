<?php

namespace App\DTOs\Dashboard\Users;

use App\Enums\Users\RoleEnum;
use App\Enums\Users\UserStatusEnum;
use App\Http\Requests\Dashboard\Users\CreateUserFormRequest;

final class CreateUserDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $username,
        public readonly string $password,
        public readonly RoleEnum $role,
        public readonly UserStatusEnum $user_status,
    ){
    }

    public static function fromRequest(CreateUserFormRequest $request): self
    {
        return new self (
            name: $request->input('name'),
            username: $request->input('username'),
            password: $request->input('password'),
            role: RoleEnum::from($request->input('role')),
            user_status: UserStatusEnum::from($request->input('status'))
        );
    }
}
