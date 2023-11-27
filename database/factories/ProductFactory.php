<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use App\Models\ProductFamily;
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
            'butch_number'=>fake()->numberBetween(10,100),
            'name'=>fake()->firstName(),
            'price'=>fake()->numberBetween(500,10000),
            'initial_quantity'=>fake()->numberBetween(10,100),
            'expiration_date'=>fake()->date(),
            'product_category_id'=>ProductCategory::all()->random()->id,
            'product_family_id'=>ProductFamily::all()->random()->id,
        ];
    }
}
