<?php

namespace App\Http\Controllers\Dashboard;

use App\DTOs\Dashboard\Users\SignInDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Users\SignInFormRequest;
use App\Services\Dashboard\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ){
    }

    public function signIn(SignInFormRequest $request): JsonResponse
    {
        $serviceResponse = $this->authService->signIn(SignInDTO::fromRequest($request));

        if ($serviceResponse->error) {
            return new JsonResponse([
                'message' => $serviceResponse->message,
            ], $serviceResponse->http_status_code);
        }

        return new JsonResponse($serviceResponse->data);
    }
}
