<?php

use App\Models\Product;
use App\Models\ProductInvoice;
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
        Schema::create('product_product_invoice', function (Blueprint $table) {
            $table->id();
            $table->integer('qty')->default(1);
            $table->foreignIdFor(ProductInvoice::class);
            $table->foreignIdFor(Product::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_invoice_product');
    }
};
