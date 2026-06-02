<?php

namespace Database\Factories;

use App\Models\NavigationItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NavigationItem>
 */
class NavigationItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parent_id' => null,
            'location' => 'main',
            'label' => fake()->words(2, true),
            'url' => '/'.fake()->slug(),
            'route_name' => null,
            'target_type' => null,
            'target_id' => null,
            'sort_order' => fake()->numberBetween(0, 50),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => false,
        ]);
    }

    public function footer(): static
    {
        return $this->state(fn (array $attributes): array => [
            'location' => 'footer',
        ]);
    }
}
