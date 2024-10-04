<?php

namespace App\Http\Controllers\Dashboard;

use App\DTOs\Dashboard\Category\CreateCategoryDTO;
use App\DTOs\Dashboard\Category\DeleteCategoryDTO;
use App\DTOs\Dashboard\Category\GetSpecificCategoryDTO;
use App\DTOs\Dashboard\Category\ListCategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Category\CreateCategoryFormRequest;
use App\Http\Requests\Dashboard\Category\ListCategoryFormRequest;
use App\Http\Resources\AnonymousResourceCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\GetSpecificCategoryResource;
use App\Http\Resources\Translation\TranslationResource;
use App\Services\Dashboard\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function listCategories(ListCategoryFormRequest $request): AnonymousResourceCollection
    {
        $serviceResponse = $this->categoryService->listCategories(ListCategoryDTO::fromRequest($request));

        return CategoryResource::collection($serviceResponse->data)
            ->withRelations([
                'translation' => [
                    'relation' => 'translations',
                    'resource' => TranslationResource::class
                ]
            ]);
    }

    public function getSpecificCategory(Request $request)
    {
        $serviceResponse = $this->categoryService->getSpecificCategory(GetSpecificCategoryDTO::fromRequest($request));

        if ($serviceResponse->error) {
            return new JsonResponse([
                'message' => $serviceResponse->message
            ], $serviceResponse->http_status_code);
        }

        return GetSpecificCategoryResource::collection($serviceResponse->data)
            ->withRelations([
                'translation' => [
                    'relation' => 'translations',
                    'resource' => TranslationResource::class
                ]
            ]);

    }

    public function deleteCategory(Request $request): JsonResponse
    {
        $serviceResponse = $this->categoryService->deleteCategory(DeleteCategoryDTO::fromRequst($request));

        if ($serviceResponse->error) {
            return new JsonResponse([
                'message' => $serviceResponse->message
            ], $serviceResponse->http_status_code);
        }

        return new JsonResponse($serviceResponse->data);
    }
}
