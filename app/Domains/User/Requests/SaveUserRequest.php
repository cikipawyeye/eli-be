<?php

declare(strict_types=1);

namespace App\Domains\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $emailRule = Rule::unique('users', 'email')->withoutTrashed();

        if ($this->route('user')) {
            $emailRule->ignore($this->route('user'), 'id');
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'max:255',
                $emailRule
            ],
            'password' => [$this->route('user') ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
            'email_verified_at' => ['nullable', 'date'],
        ];
    }
}
