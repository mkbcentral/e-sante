<?php

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
        Schema::table('consultation_sheets', function (Blueprint $table) {
            $table->foreignIdFor(Source::class)->nullable()->after('registration_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultation_sheets', function (Blueprint $table) {
            $table->dropColumn('source_id');
        });
    }
};
