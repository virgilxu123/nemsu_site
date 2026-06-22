<?php

namespace Database\Factories;

use App\Models\JobOpportunity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<JobOpportunity>
 */
class JobOpportunityFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->sentence(5);

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::lower(Str::random(6)),
            'content' => '<p>'.fake()->paragraph().'</p>',
            'date' => fake()->dateTimeBetween('-3 months', '+1 month'),
            'is_hiring' => false,
            'is_published' => false,
        ];
    }

    public function hiring(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_hiring' => true,
        ]);
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => true,
        ]);
    }
}
