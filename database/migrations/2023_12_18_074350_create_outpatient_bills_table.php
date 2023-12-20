<?php

use App\Models\Consultation;
use App\Models\Currency;
use App\Models\Hospital;
use App\Models\Rate;
use App\Models\User;
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
        Schema::create('outpatient_bills', function (Blueprint $table) {
            $table->id();
            $table->string('bill_number')->unique();
            $table->string('client_name')->nullable();
            $table->boolean('is_validated')->default(false);
            $table->boolean('is_printed')->default(false);
            $table->foreignIdFor(Consultation::class);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Hospital::class);
            $table->foreignIdFor(Rate::class);
            $table->foreignIdFor(Currency::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outpatient_bills');
    }
};
