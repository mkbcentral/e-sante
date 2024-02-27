<?php

use App\Models\ConsultationRequest;
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
        Schema::create('consultation_request_currencies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ConsultationRequest::class);
            $table->float('amount_usd')->default(0);
            $table->float('amount_cdf')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_request_currencies');
    }
};
