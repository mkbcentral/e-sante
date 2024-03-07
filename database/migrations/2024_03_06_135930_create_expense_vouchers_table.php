<?php

use App\Models\AgentService;
use App\Models\CategorySpendMoney;
use App\Models\Currency;
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
        Schema::create('expense_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('name');
            $table->string('description');
            $table->float('amount',16)->default(0);
            $table->boolean('is_valided')->default(false);
            $table->foreignIdFor(AgentService::class);
            $table->foreignIdFor(CategorySpendMoney::class);
            $table->foreignIdFor(Currency::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_vouchers');
    }
};
