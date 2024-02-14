<?php

use App\Models\AgentService;
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
        Schema::create('product_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->foreignIdFor(AgentService::class);
            $table->foreignIdFor(Hospital::class);
            $table->foreignIdFor(Source::class);
            $table->boolean('is_valided')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_requisitions');
    }
};
