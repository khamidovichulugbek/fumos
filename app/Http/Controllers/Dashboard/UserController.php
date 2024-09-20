<?php

namespace App\Http\Controllers\Dashboard;

use App\DTOs\Dashboard\Users\CreateUserDTO;
use App\DTOs\Dashboard\Users\ListUsersDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Users\CreateUserFormRequest;
use App\Http\Requests\Dashboard\Users\ListUserFormRequest;
use App\Services\Dashboard\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ){
    }

    public function createUser (CreateUserFormRequest $request): JsonResponse
    {
        $serviceResponse = $this->userService->createUser(CreateUserDTO::fromRequest($request));

        return new JsonResponse($serviceResponse->data);
    }

    public function listUsers (ListUserFormRequest $request): JsonResponse
    {
        $serviceResponse = $this->userService->listUsers(ListUsersDTO::fromRequest($request));

        return new JsonResponse($serviceResponse);
    }
}
