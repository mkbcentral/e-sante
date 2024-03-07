<?php

use App\Models\Currency;
use App\Models\Hospital;
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
        Schema::create('note_money_sendings', function (Blueprint $table) {
            $table->id();
            $table->string('sender');
            $table->string('recever');
            $table->float('amount',16)->default(0);
            $table->boolean('is_valided')->default(false);
            $table->foreignIdFor(Currency::class);
            $table->foreignIdFor(Hospital::class);
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_money_sendings');
    }
};
