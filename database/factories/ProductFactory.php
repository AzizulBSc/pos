<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => fake()->imageUrl(),
            'name' => fake()->word(),
            'slug' => fake()->unique()->slug(),
            'sku' => fake()->unique()->ean8(),
            'barcode' => fake()->ean13(),
            'description' => fake()->paragraph(),
            'category_id' => \App\Models\Category::inRandomOrder()->first()?->id,
            'brand_id' => \App\Models\Brand::inRandomOrder()->first()?->id,
            'unit_id' => \App\Models\Unit::inRandomOrder()->first()?->id,
            'price' => fake()->randomFloat(2, 10, 1000),
            'discount' => fake()->randomFloat(2, 0, 100),
            'discount_type' => fake()->randomElement(['fixed', 'percentage']),
            'purchase_price' => fake()->randomFloat(2, 5, 500),
            'quantity' => fake()->numberBetween(0, 1000),
            'expire_date' => fake()->optional()->date(),
            'low_stock_threshold' => fake()->optional()->numberBetween(5, 20),
            'status' => fake()->boolean(),
            'rating' => fake()->optional()->numberBetween(1, 5)
        ];
    }
}
