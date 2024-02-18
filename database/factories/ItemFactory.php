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

        $products = DB::table('products')->get();
        $product_id = fake()->randomElement($products->pluck('id'));
        $product = $products->where('id',$product_id)->first();

        $unitPrice = $product->price;
        $quantity = fake()->randomNumber(2);
        $totalPrice = $unitPrice * $quantity;

        return [
            'product_id' => $product_id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice
        ];
    }
}
