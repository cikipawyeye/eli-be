<?php

namespace App\Domains\Notification\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'emotion_id' => ['required', 'integer', Rule::exists('emotions', 'id')->withoutTrashed()],
            'content' => ['required', 'string'],
        ];
    }
}
