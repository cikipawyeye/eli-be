<?php

declare(strict_types=1);

namespace App\Domains\Content\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subcategory_id' => ['required', 'integer', 'exists:subcategories,id'],
            'title' => ['required', 'string', 'max:100'],
            'image' => ['required', 'image', 'max:4096'],
            'premium' => ['required', 'boolean'],
        ];
    }
}
