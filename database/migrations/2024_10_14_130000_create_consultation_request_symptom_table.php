<?php

use App\Models\Symptom;
use App\Models\ConsultationRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consultation_request_symptom', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ConsultationRequest::class)->constrained();
            $table->foreignIdFor(Symptom::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_request_symptom');
    }
};
