<?php

use App\Models\Product;
use App\Models\ProductRequisition;
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
        Schema::create('product_requisition_products', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')->default(1);
            $table->foreignIdFor(Product::class);
            $table->foreignIdFor(ProductRequisition::class);
            $table->boolean('is_delivered')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_requisition_products');
    }
};
