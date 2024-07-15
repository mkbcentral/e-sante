<?php

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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('pharma_g_stk')->default(0)->after('initial_quantity');
            $table->integer('pharma_v_stk')->default(0)->after('pharma_g_stk');
            $table->integer('pharma_klz_stk')->default(0)->after('pharma_v_stk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('pharma_g_stk');
            $table->dropColumn('pharma_v_stk');
            $table->dropColumn('pharma_klz_stk');
        });
    }
};
