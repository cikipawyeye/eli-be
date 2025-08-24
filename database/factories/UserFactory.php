<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\User\Enums\GenderEnum;
use App\Domains\User\Enums\JobTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\User\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = \App\Domains\User\Models\User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jobType = JobTypeEnum::getCollection()->random();

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->freeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'city_code' => fake()->numberBetween(1101, 9471),
            'job_type' => $jobType,
            'job' => $jobType == JobTypeEnum::Other->value ? fake()->jobTitle() : null,
            'birth_date' => fake()->date(),
            'is_premium' => fake()->boolean(),
            'phone_number' => fake()->phoneNumber(),
            'gender' => GenderEnum::getCollection()->random(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
