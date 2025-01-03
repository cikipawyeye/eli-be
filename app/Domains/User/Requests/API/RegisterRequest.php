<?php

declare(strict_types=1);

namespace App\Domains\User\Requests\API;

use App\Domains\User\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Password::defaults()],
            'birth_date' => 'required|date|before:today',
            'city_code' => ['required', Rule::exists(config('laravolt.indonesia.table_prefix') . 'cities', 'code')],
            'job' => 'required|string|max:50',
            'phone_number' => 'required|string|max:19',
        ];
    }
}
