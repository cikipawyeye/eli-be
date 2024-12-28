<?php

namespace App\Domains\Content\Requests;

use App\Domains\Content\Enums\ContentCategoryEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveSubcategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'is_active' => ['required', 'boolean'],
            'category' => ['required', 'string', Rule::enum(ContentCategoryEnum::class)],
        ];
    }
}
