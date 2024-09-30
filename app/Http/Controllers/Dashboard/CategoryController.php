<?php

namespace App\Http\Controllers\Dashboard;

use App\DTOs\Dashboard\Category\CreateCategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Category\CreateCategoryFormRequest;
use App\Http\Resources\AnonymousResourceCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Translation\TranslationResource;
use App\Services\Dashboard\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    ){
    }

    public function createCategory(CreateCategoryFormRequest $request): JsonResponse
    {
        $serviceResponse = $this->categoryService->createCategory(CreateCategoryDTO::fromRequest($request));

        return new JsonResponse($serviceResponse->data);
    }

    public function listCategories(): AnonymousResourceCollection
    {
        $serviceResponse = $this->categoryService->listCategories();

        return CategoryResource::collection($serviceResponse->data)
            ->withRelations([
                'translation' => [
                    'relation' => 'translations',
                    'resource' => TranslationResource::class
                ]
            ]);
    }
}
