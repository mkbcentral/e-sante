<?php

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
        Schema::create('consultation_request_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\ConsultationRequest::class);
            $table->foreignIdFor(\App\Models\Product::class);
            $table->integer('qty')->default(0);
            $table->string('dosage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_request_product');
    }
};
