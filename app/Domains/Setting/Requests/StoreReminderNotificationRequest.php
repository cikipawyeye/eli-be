<?php

namespace App\Domains\Setting\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReminderNotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
