<?php

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
        Schema::table('consultation_request_tarif', function (Blueprint $table) {
            $table->string('normal_value')->nullable()->after('result');
            $table->string('unit')->nullable()->after('normal_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultation_request_tarif', function (Blueprint $table) {
            $table->dropColumn('normal_value');
            $table->dropColumn('unit');
        });
    }
};
