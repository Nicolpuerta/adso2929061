<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\pet>
 */
class petFactory extends Factory
{
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        'name'         => fake()->colorName,
        'kind'         => fake()->randomElement(['Dog', 'Cat', 'Pig', 'Mouse']),
        'weight'       => fake()->numerify('#.#'),
        'age'          => fake()->numberBetween(1, 15),
        'breed'        => fake()->randomElement(['Type1', 'Type2', 'Type3']),
        'location'     => fake()->city,
        'description' => fake()->sentence(5)
        ];
    }
}
