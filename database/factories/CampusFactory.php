<?php

namespace Database\Factories;

use App\Models\Campus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Campus>
 */
class CampusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->city().' Campus';

        return [
            'id' => (string) Str::uuid(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
        ];
    }
}
