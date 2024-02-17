<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subtotal' => fake()->numberBetween(1, 500),
            'priority' => fake()->randomNumber(2),
            'deliver' => fake()->dateTimeBetween('now', '+3 week')
        ];
    }
}
