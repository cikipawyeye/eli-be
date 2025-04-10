<?php

namespace App\Domains\Theme\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWallpaperRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'file' => ['required', 'mimes:jpeg,png,jpg,gif,webp,mp4', 'max:20480'],
        ];
    }
}
