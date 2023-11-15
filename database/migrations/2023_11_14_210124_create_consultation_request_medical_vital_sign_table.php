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
        Schema::create('consultation_request_vital_sign', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\ConsultationRequest::class);
            $table->integer('value')->default(0);
            $table->foreignIdFor(\App\Models\VitalSign::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_request_vital_sign');
    }
};
