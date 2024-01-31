<?php

use App\Models\Product;
use App\Models\ProductSupply;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_supply_products', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')->default(10);
            $table->foreignIdFor(Product::class);
            $table->foreignIdFor(ProductSupply::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_supply_products');
    }
};
