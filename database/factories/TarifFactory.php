<?php

namespace Database\Factories;

use App\Models\CategoryTarif;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tarif>
 */
class TarifFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>fake()->firstName(),
            'price_private'=>fake()->numberBetween(10-1000),
            'subscriber_price'=>fake()->numberBetween(10-1000),
            'category_tarif_id'=>CategoryTarif::all()->random()->id,
        ];
    }
}
