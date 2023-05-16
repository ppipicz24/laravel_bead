<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //$start = fake()->dateTimeBetween('-5 week', '+5 week');
        return [
            
            'start' => fake()->dateTimeBetween('-5 week', '+5 week'),
            'finished' => fake()->boolean(),
        ];
    }
}
