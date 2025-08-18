<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\Content\Enums\ContentCategoryEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Content\Models\Subcategory>
 */
class SubcategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = \App\Domains\Content\Models\Subcategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'category' => ContentCategoryEnum::getCollection()->random(),
            'is_active' => fake()->boolean(),
            'premium' => fake()->boolean(),
        ];
    }

    public function motivation(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => ContentCategoryEnum::Motivation->value,
        ]);
    }

    public function reminder(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => ContentCategoryEnum::Reminder->value,
        ]);
    }
}
