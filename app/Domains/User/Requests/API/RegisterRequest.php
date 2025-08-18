<?php

declare(strict_types=1);

namespace App\Domains\User\Requests\API;

use App\Domains\User\Enums\GenderEnum;
use App\Domains\User\Enums\JobTypeEnum;
use App\Domains\User\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function attributes()
    {
        return [
            'name' => __('app.name'),
            'email' => __('app.email'),
            'birth_date' => __('app.birth_date'),
            'city_code' => __('app.city'),
            'job_type' => __('app.job_type'),
            'job' => __('app.job'),
            'phone_number' => __('app.phone_number'),
            'gender' => __('app.gender'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'lowercase',
                'max:255',
                Rule::unique(User::class, 'email')->withoutTrashed(),
                app()->runningUnitTests() ? 'email' :  'email:rfc,dns,spoof',
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone_number' => 'required|string|max:19',
            'birth_date' => 'nullable|date|before:today',
            'city_code' => [
                'nullable',
                Rule::exists(config('laravolt.indonesia.table_prefix') . 'cities', 'code')
            ],
            'job_type' => ['nullable', Rule::enum(JobTypeEnum::class)],
            'job' => [
                sprintf('exclude_unless:job_type,%s', JobTypeEnum::Other->value),
                sprintf('required_if:job_type,%s', JobTypeEnum::Other->value),
                'string',
                'max:50'
            ],
            'gender' => ['nullable', Rule::enum(GenderEnum::class)],
        ];
    }

    public function messages()
    {
        return [
            'job.required_if' => __(
                'validation.required_if',
                ['attribute' => __('app.job'), 'value' => JobTypeEnum::Other->translated()]
            ),
        ];
    }
}
