<?php

namespace App\DTOs\Dashboard\Users;

use App\Http\Requests\Dashboard\Users\ListUserFormRequest;

final class ListUsersDTO
{
    public function __construct(
        public readonly ?string $search_query,
        public readonly ?int $role_id,
        public readonly ?int $status
    ){
    }

    public static function  fromRequest(ListUserFormRequest $request): self
    {
        return new self(
            search_query: $request->has('search_query') ? $request->query('search_query'): null,
            role_id: $request->has('role_id') ? $request->query('role_id'): null,
            status: $request->has('status') ? $request->query('status') : null
        );
    }
}
