<?php

declare(strict_types=1);

namespace App\Domains\Content\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrowseContentRequest extends FormRequest
{
    public function attributes()
    {
        return ['subcategory_id' => __('app.subcategory_id')];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subcategory_id' => ['required', 'integer', Rule::exists('subcategories', 'id')->withoutTrashed()],
        ];
    }
}
