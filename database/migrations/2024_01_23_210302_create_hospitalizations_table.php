<?php

use App\Models\Hospital;
use App\Models\Source;
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
        Schema::create('hospitalizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('price_private')->default(0);
            $table->double('subscriber_price')->default(0);
            $table->boolean('is_changed')->default(false);
            $table->foreignIdFor(Hospital::class);
            $table->foreignIdFor(Source::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalizations');
    }
};
