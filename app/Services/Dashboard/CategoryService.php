<?php

namespace App\Services\Dashboard;

use App\DTOs\Dashboard\Category\CreateCategoryDTO;
use App\DTOs\ServiceResponseDTO;
use App\Models\Category;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use Slug;

final class CategoryService
{
    public function __construct(
        private ResponseService $responseService
    ){
    }

    public function createCategory(CreateCategoryDTO $dto): ServiceResponseDTO
    {
        $category = new Category();
        $category->is_active = $dto->is_active;

        if ($dto->parent_id !== null) {
            $category->parent_id = $dto->parent_id;
        }

        DB::transaction(function () use ($category, $dto) {
            $category->save();

            $category->translations()->createMany($dto->translations);
            $category->slug = Slug::generateSlug(
                title: $category->translations()
                    ->where('locale', '=', 'uz')
                    ->first()
                    ->title,
                id: $category->id
            );

            $category->save();
        });

        return $this->responseService->successfulServiceResponse([
            'message' => trans('categories.category-created'),
            'category' => $category->withoutRelations(),
        ]);
    }

    public function listCategories(): ServiceResponseDTO
    {
        $categories = Category::with('translations')->get();

        return $this->responseService->successfulServiceResponse($categories);
    }
}
