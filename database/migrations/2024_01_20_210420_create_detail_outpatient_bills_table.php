<?php

use App\Models\OutpatientBill;
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
        Schema::create('detail_outpatient_bills', function (Blueprint $table) {
            $table->id();
            $table->float('amount_cdf')->default(0);
            $table->float('amount_usd')->default(0);
            $table->foreignIdFor(OutpatientBill::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_outpatient_bills');
    }
};
