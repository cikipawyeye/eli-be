<?php

namespace App\Domains\Notification\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @method mixed route(string $key)
 */
class SaveEmotionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $emotion = $this->route('emotion');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('emotions')->ignore($emotion)->withoutTrashed()],
        ];
    }
}
