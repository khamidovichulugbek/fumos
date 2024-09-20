<?php

namespace App\Http\Requests\Dashboard\Users;

use App\Enums\Users\UserStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ListUserFormRequest extends FormRequest
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
            'search_query' => ['nullable','string'],
            'role_id' => ['nullable', 'integer'],
            'status' => ['nullable', new Enum(UserStatusEnum::class)]
        ];
    }
}
