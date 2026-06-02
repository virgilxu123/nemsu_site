<?php

namespace Database\Factories;

use App\Models\ContentPage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ContentPage>
 */
class ContentPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(6)),
            'section' => fake()->optional()->randomElement(['about', 'admissions', 'academics']),
            'body' => '<p>'.fake()->paragraph().'</p>',
            'excerpt' => fake()->optional()->sentence(),
            'status' => 'draft',
            'is_published' => false,
            'published_at' => null,
            'office_id' => null,
            'campus_id' => null,
            'sort_order' => fake()->numberBetween(0, 50),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => 'published',
            'is_published' => true,
            'published_at' => now(),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => 'draft',
            'is_published' => false,
            'published_at' => null,
        ]);
    }
}
