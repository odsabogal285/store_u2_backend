<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $products_id = DB::table('products')->pluck('id');
        $orders_id = DB::table('orders')->pluck('id');

        return [
            'product_id' => fake()->randomElement($products_id),
            'order_id' => fake()->randomElement($orders_id),
            'quantity' => fake()->randomNumber(2),
            'unit_price' => fake()->randomNumber(2),
            'total_price' => fake()->randomNumber(2)
        ];
    }
}
