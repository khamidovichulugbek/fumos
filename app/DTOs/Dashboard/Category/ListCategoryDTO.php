<?php

namespace App\DTOs\Dashboard\Category;

use App\Http\Requests\Dashboard\Category\ListCategoryFormRequest;

final class ListCategoryDTO
{
    public function __construct(
        public readonly int $current_page = 1,
        public readonly ?string $title,
        public readonly ?bool $is_active,
    ){
    }

    public static function fromRequest(ListCategoryFormRequest $request): self
    {
        return new self (
            current_page: $request->has('page') ? $request->integer('page') : 1,
            title: $request->query('title'),
            is_active: $request->has('is_active') ? $request->boolean('is_active') : null,
        );
    }
}
