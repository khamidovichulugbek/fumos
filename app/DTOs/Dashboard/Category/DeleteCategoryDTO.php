<?php

namespace App\DTOs\Dashboard\Category;

use Illuminate\Http\Request;

final class DeleteCategoryDTO
{
    public function __construct(
        public readonly int $category_id
    ){
    }

    public static function fromRequst(Request $request): self
    {
        return new self (
            category_id: $request->route('categoryId')
        );
    }
}
