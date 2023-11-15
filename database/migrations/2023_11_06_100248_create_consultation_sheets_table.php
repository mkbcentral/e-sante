<?php

use App\Models\AgentService;
use App\Models\Hospital;
use App\Models\Subscription;
use App\Models\TypePatient;
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
        Schema::create('consultation_sheets', function (Blueprint $table) {
            $table->id();
            $table->string('number_sheet');
            $table->string('name');
            $table->date('date_of_birth')->nullable();
            $table->string('phone')->nullable();
            $table->string('other_phone')->nullable();
            $table->string('email')->nullable();
            $table->enum('gender', ['M', 'F']);
            $table->string('blood_group')->nullable();
            $table->string('municipality')->nullable();
            $table->string('rural_area')->nullable();
            $table->string('street')->nullable();
            $table->string('street_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->foreignIdFor(TypePatient::class);
            $table->foreignIdFor(Subscription::class);
            $table->foreignIdFor(AgentService::class)->nullable();
            $table->foreignIdFor(Hospital::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_sheets');
    }
};
