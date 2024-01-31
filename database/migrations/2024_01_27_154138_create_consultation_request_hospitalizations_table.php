<?php

use App\Models\ConsultationRequest;
use App\Models\HospitalizationRoom;
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
        Schema::create('consultation_request_hospitalizations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ConsultationRequest::class);
            $table->foreignIdFor(HospitalizationRoom::class);
            $table->integer('number_of_day')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_request_hospitalizations');
    }
};
