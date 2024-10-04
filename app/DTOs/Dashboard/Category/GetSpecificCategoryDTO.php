<?php

namespace App\DTOs\Dashboard\Category;

use Illuminate\Http\Request;

final class GetSpecificCategoryDTO
{
    public function __construct(
        public readonly int $category_id,
    ){
    }

    public static function fromRequest(Request $request): self
    {
        return new self (
            category_id: $request->route('categoryId')
        );
    }
}
