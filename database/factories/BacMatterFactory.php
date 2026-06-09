<?php

namespace Database\Factories;

use App\Models\BacMatter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BacMatter>
 */
class BacMatterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(5),
            'file' => fake()->optional()->lexify('documents/????.pdf'),
            'link' => fake()->optional()->url(),
            'type' => fake()->randomElement(['ITB', 'RFQ', 'NOA', 'NTP', 'Bid Bulletin', 'Bid Bulletin 2']),
            'date' => fake()->dateTimeBetween('-1 year'),
            'is_published' => false,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => true,
        ]);
    }
}
