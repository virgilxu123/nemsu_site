<?php

namespace Database\Factories;

use App\Models\College;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<College>
 */
class CollegeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company().' College';
        $code = strtoupper(fake()->unique()->bothify('C??'));

        return [
            'id' => (string) Str::uuid(),
            'code' => $code,
            'name' => $name,
            'slug' => Str::slug($name),
            'banner' => null,
            'description' => fake()->paragraph(),
        ];
    }
}
