<?php

use App\Models\PayrollSource;
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
        Schema::table('expense_vouchers', function (Blueprint $table) {
            $table->foreignIdFor(PayrollSource::class)->nullable()->after('currency_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expense_vouchers', function (Blueprint $table) {
            $table->dropColumn('payroll_source_id');
        });
    }
};
