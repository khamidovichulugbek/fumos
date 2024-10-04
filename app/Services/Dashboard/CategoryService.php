<?php

namespace App\Services\Dashboard;

use App\DTOs\Dashboard\Category\CreateCategoryDTO;
use App\DTOs\Dashboard\Category\DeleteCategoryDTO;
use App\DTOs\Dashboard\Category\GetSpecificCategoryDTO;
use App\DTOs\Dashboard\Category\ListCategoryDTO;
use App\DTOs\ServiceResponseDTO;
use App\Models\Category;
use App\Services\ResponseService;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Can;
use Slug;

final class CategoryService
{
    private const PAGINATION_DEFAULT_LIMIT = 15;

    public function __construct(
        private ResponseService $responseService,
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

    public function listCategories(ListCategoryDTO $dto): ServiceResponseDTO
    {

        $categoriesQuery = Category::with(['translations']);

        if ($dto->title !== null) {
            $categoriesQuery->whereRelation(
                'translations',
                'title',
                'ILIKE',
                "%{$dto->title}%"
            );
        }

        if ($dto->is_active !== null) {
            $categoriesQuery->where('is_active', '=', $dto->is_active);
        }

        $category = $categoriesQuery->paginate(self::PAGINATION_DEFAULT_LIMIT);

        return $this->responseService->successfulServiceResponse($category);
    }

    public function getSpecificCategory(GetSpecificCategoryDTO $dto): ServiceResponseDTO
    {
        $category = Category::find($dto->category_id);

        if (! $category) {
            return $this->responseService->failedServiceResponse(
                message: trans('categories.category-not-found'),
                httpStatusCode: 404
            );
        }
        $category = $category->with('translations')
            ->where('id', '=', $dto->category_id)
            ->get();

        return $this->responseService->successfulServiceResponse($category);
    }

    public function deleteCategory(DeleteCategoryDTO $dto): ServiceResponseDTO
    {
        $category = Category::find($dto->category_id);

        if (! $category) {
            return $this->responseService->failedServiceResponse(
                message: trans('categories.category-not-found'),
                httpStatusCode: 404
            );
        }

        DB::transaction(function () use ($category) {
            $category->translations()->chunkById(20, function ($translation) use ($category) {
                $category->translations()->delete($translation->pluck('id')->toArray());
            });

            $category->delete();
        });

        return $this->responseService->successfulServiceResponse([
            'message' => trans('categories.category-deleted')
        ]);

    }
}
