<?php

use App\Models\Hospital;
use App\Models\ProductCategory;
use App\Models\ProductFamily;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('butch_number')->nullable();
            $table->string('name');
            $table->double('price')->default(0);
            $table->integer('initial_quantity');
            $table->date('expiration_date');
            $table->foreignIdFor(ProductCategory::class)->nullable();
            $table->foreignIdFor(ProductFamily::class)->nullable();
            $table->foreignIdFor(Hospital::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
