<?php

namespace App\Domains\Notification\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SaveReminderNotificationRequest
 *
 * @method bool routeIs(string $name)
 * @method ?\Illuminate\Http\UploadedFile file(string $name, mixed $default = null)
 */
class SaveReminderNotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isUpdate = $this->routeIs('reminder-notifications.update');
        
        return [
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'is_active' => 'boolean',
            'image' => $isUpdate ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];
    }
}
