*<?php

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
        Schema::table('category_tarifs', function (Blueprint $table) {
            $table->foreignIdFor(Source::class)->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_tarifs', function (Blueprint $table) {
            $table->dropColumn('hospital_id');
        });
    }
};
