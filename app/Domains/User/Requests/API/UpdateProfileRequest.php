<?php

declare(strict_types=1);

namespace App\Domains\User\Requests\API;

use App\Domains\User\Enums\GenderEnum;
use App\Domains\User\Enums\JobTypeEnum;
use App\Domains\User\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id)->withoutTrashed(),
            ],
            'birth_date' => 'required|date|before:today',
            'city_code' => ['required', Rule::exists(config('laravolt.indonesia.table_prefix').'cities', 'code')],
            'job_type' => ['required', Rule::enum(JobTypeEnum::class)],
            'job' => [sprintf('exclude_unless:job_type,%s', JobTypeEnum::Other->value), sprintf('required_if:job_type,%s', JobTypeEnum::Other->value), 'string', 'max:50'],
            'phone_number' => 'required|string|max:19',
            'gender' => ['required', Rule::enum(GenderEnum::class)],
        ];
    }

    public function messages()
    {
        return [
            'job.required_if' => __('validation.required_if', ['attribute' => __('app.job'), 'value' => JobTypeEnum::Other->translated()]),
        ];
    }
}
