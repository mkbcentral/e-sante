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
            'price_private'=>rand(10,1000),
            'subscriber_price'=>rand(10,100),
            'category_tarif_id'=>CategoryTarif::all()->random()->id,
        ];
    }
}
