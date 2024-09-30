<?php

namespace App\DTOs\Dashboard\Category;

use App\Http\Requests\Dashboard\Category\CreateCategoryFormRequest;

final class CreateCategoryDTO {
    public function __construct(
        public readonly array $translations,
        public readonly bool $is_active,
        public readonly ?int $parent_id,
    ){
    }

    public static function fromRequest(CreateCategoryFormRequest $request) {

        return new self (
            translations: $request->input('translations'),
            is_active: $request->input('is_active'),
            parent_id: $request->input('parent_id'),
        );
    }
}
