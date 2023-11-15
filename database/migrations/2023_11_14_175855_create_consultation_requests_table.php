<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ConsultationSheet;
use App\Models\Rate;
use App\Models\Consultation;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consultation_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number');
            $table->foreignIdFor(ConsultationSheet::class);
            $table->foreignIdFor(Consultation::class);
            $table->foreignIdFor(Rate::class);
            $table->integer('consulted_by')->default(0);
            $table->integer('printed_by')->default(0);
            $table->integer('validated_by')->default(0);
            $table->boolean('is_validated')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_printed')->default(false);
            $table->boolean('is_finished')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_requests');
    }
};
