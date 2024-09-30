<?php

namespace App\Http\Requests\Dashboard\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCategoryFormRequest extends FormRequest
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
            'translations' => ['required', 'array', 'size:2'],
            'translations.*.title' => ['required', 'string', 'max:200'],
            'translations.*.locale' => [
                'required', 'string', 'size:2',
                Rule::in(config('app.available_locales')),
            ],
            'is_active' => ['required', 'bool'],
            'parent_id' => ['integer', Rule::exists(Category::class, 'id')],
        ];
    }
}
