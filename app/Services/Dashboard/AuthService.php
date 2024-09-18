<?php

namespace App\Services\Dashboard;

use App\DTOs\Dashboard\Users\SignInDTO;
use App\DTOs\ServiceResponseDTO;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Hash;

final class AuthService
{
    public function __construct(
        private ResponseService $responseService
    ){
    }

    public function signIn(SignInDTO $dto): ServiceResponseDTO
    {
        $user = User::with('role')
            ->where('username', '=', $dto->username)->first();

        if (! $user) {
            return $this->responseService->failedServiceResponse(
                message: trans('user.not-found'),
                httpStatusCode: 404
            );
        }

        if (!Hash::check($dto->password, $user->password)) {
            return $this->responseService->failedServiceResponse(
                message: trans('user.incorrect-password'),
                httpStatusCode: 401
            );
        }

        $bearerToken = $user->createToken($user->id)
            ->plainTextToken;

        return $this->responseService->successfulServiceResponse(
            data: [
                'bearer-token' => $bearerToken,
                'user' => $user
            ],
            message: trans('user.singed-in')
        );
    }
}
