<?php

use App\Models\ConsultationSheet;
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
        Schema::table('outpatient_bills', function (Blueprint $table) {
            $table->boolean('is_hospitalized')->default(false)->after('currency_id');
            $table->foreignIdFor(ConsultationSheet::class)->nullable()->after('is_hospitalized');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outpatient_bills', function (Blueprint $table) {
            $table->dropColumn('is_hospitalized');
            $table->dropColumn('consultation_sheet_id');
        });
    }
};
