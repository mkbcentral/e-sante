<?php

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
            $table->foreignIdFor(\App\Models\ProductCategory::class);
            $table->foreignIdFor(\App\Models\ProductFamily::class);
            $table->foreignIdFor(\App\Models\Hospital::class);
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
