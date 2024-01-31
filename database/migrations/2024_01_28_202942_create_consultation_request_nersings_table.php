<?php

use App\Models\ConsultationRequest;
use App\Models\Currency;
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
        Schema::create('consultation_request_nersings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('amount')->default(0);
            $table->integer('number')->default(0);
            $table->foreignIdFor(ConsultationRequest::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_request_nersings');
    }
};
