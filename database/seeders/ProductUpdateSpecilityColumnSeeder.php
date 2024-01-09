<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductUpdateSpecilityColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products=Product::all();
        foreach ($products as $product) {
           $product->is_specialty=rand(0,1);
           $product->update();
        }
    }
}
