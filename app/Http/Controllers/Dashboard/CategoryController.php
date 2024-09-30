<?php

namespace App\Http\Controllers\Dashboard;

use App\DTOs\Dashboard\Category\CreateCategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Category\CreateCategoryFormRequest;
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
}
