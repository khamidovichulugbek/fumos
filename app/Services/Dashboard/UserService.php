<?php

namespace App\Services\Dashboard;

use App\DTOs\Dashboard\Users\CreateUserDTO;
use App\DTOs\ServiceResponseDTO;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Hash;
use App\DTOs\Dashboard\Users\ListUsersDTO;

final class UserService
{
    public function __construct(
        private ResponseService $responseService
    ){
    }

    private const PAGINATION_DEFAULT_LIMIT = 15;


    public function listUsers(ListUsersDTO $dto): ServiceResponseDTO
    {
        $users = User::with('role');

        if ($dto->role_id !== null) {
            $users->where('role_id', '=', $dto->role_id);
        }

        if ($dto->status !== null) {
            $users->where('status', '=', $dto->status);
        }

        if ($dto->search_query !== null) {
            $users->where(function ($builder) use ($dto) {
                return $builder->where('name', 'ILIKE', "%{$dto->search_query}%")
                    ->orWhere('username', 'ILIKE', "%{$dto->search_query}%")
                    ->orWhere('phone', 'ILIKE', "%{$dto->search_query}%");
            });
        }

        $users = $users->paginate(self::PAGINATION_DEFAULT_LIMIT)
            ->withQueryString();

        return $this->responseService->successfulServiceResponse($users);
    }

    public function createUser(CreateUserDTO $dto): ServiceResponseDTO
    {
        $user = new User();
        $user->name = $dto->name;
        $user->username = $dto->username;
        $user->password = Hash::make($dto->password);
        $user->role_id = $dto->role->value;
        $user->status = $dto->user_status->value;
        $user->save();

        return $this->responseService->successfulServiceResponse([
            'data' => $user,
            'message' => trans('user.created')
        ]);
    }
}
