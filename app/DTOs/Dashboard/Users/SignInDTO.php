<?php

namespace App\DTOs\Dashboard\Users;

use App\Http\Requests\Dashboard\Users\SignInFormRequest;

final class SignInDTO
{
    public function __construct(
        public readonly string $username,
        public readonly string $password
    ){
    }

    public static function fromRequest(SignInFormRequest $request): self
    {
        return new self (
            username: $request->input('username'),
            password: $request->input('password')
        );
    }
}
