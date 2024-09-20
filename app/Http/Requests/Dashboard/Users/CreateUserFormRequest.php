<?php

namespace App\Http\Requests\Dashboard\Users;

use App\Enums\Users\UserStatusEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CreateUserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string', 'min:1', 'max:255'],
            'username' => [
                'string',
                'required',
                Rule::unique(User::class, 'username'),
                'min:3',
                'max:255'
            ],
            'status' => ['required', 'integer', new Enum(UserStatusEnum::class)],
            'password' => ['required', 'string', 'min:8'],
            'role' => [
                'integer',
                'required',
                Rule::exists(Role::class, 'id')
            ]
        ];
    }
}
