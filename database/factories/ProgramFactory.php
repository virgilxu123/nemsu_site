<?php

namespace Database\Factories;

use App\Models\Campus;
use App\Models\College;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('PRG###')),
            'name' => fake()->unique()->sentence(4),
            'loa' => null,
            'prospectus' => null,
            'description' => fake()->paragraph(),
            'college_id' => College::factory(),
            'campus_id' => Campus::factory(),
            'degree_program' => fake()->randomElement(['graduate studies', 'baccalaureate', 'associate']),
            'is_archived' => false,
        ];
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_archived' => true,
        ]);
    }
}
