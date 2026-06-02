<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(6)),
            'short_description' => fake()->paragraph(),
            'content' => '<p>'.fake()->paragraph().'</p>',
            'photo' => fake()->optional()->imageUrl(1200, 700),
            'author' => fake()->optional()->company(),
            'office_id' => null,
            'type' => 'news',
            'is_published' => false,
            'featured' => false,
            'date' => fake()->dateTimeBetween('-1 year', '+1 month'),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => true,
            'date' => now(),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => false,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes): array => [
            'featured' => true,
            'is_published' => true,
        ]);
    }
}
