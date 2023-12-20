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
        Schema::create('outpatient_bill_tarif', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\OutpatientBill::class);
            $table->foreignIdFor(\App\Models\Tarif::class);
            $table->integer('qty')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outpatient_bill_tarif');
    }
};
