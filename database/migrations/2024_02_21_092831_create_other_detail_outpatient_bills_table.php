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
        Schema::create('other_detail_outpatient_bills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('amount');
            $table->foreignIdFor(OutpatientBill::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_detail_outpatient_bills');
    }
};
