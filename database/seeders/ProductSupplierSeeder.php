<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $suppliers = Supplier::all();

        $products->each(function ($product) use ($suppliers) {
            $product->suppliers()->attach(
                $suppliers->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
