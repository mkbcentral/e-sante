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
        Schema::create('cautions', function (Blueprint $table) {
            $table->id();
            $table->float('amount',16)->default(0);
            $table->foreignIdFor(ConsultationRequest::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cautions');
    }
};
