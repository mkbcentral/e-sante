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
        Schema::create('consultation_request_diagnostic', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\ConsultationRequest::class);
            $table->foreignIdFor(\App\Models\Diagnostic::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_request_diagnostic');
    }
};
