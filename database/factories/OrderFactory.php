<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Order;
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
            'priority' => fake()->randomNumber(2),
            'deliver' => fake()->dateTimeBetween('now', '+1 week')
        ];
    }

    public function configure()
    {

        return $this->afterCreating(function (Order $order) {
            $itemsCount = mt_rand(1, 5);
            $items = Item::factory()->count($itemsCount)->create(['order_id' => $order->id]);
            $subtotal = $items->sum('total_price');
            $order->subtotal = $subtotal;
            $order->save();
        });
    }
}
