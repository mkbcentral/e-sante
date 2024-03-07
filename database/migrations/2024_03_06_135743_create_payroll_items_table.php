<?php

use App\Models\AgentService;
use App\Models\Payroll;
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
        Schema::create('payroll_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('amount', 16)->default(0);
            $table->boolean('is_valided')->default(false);            $table->foreignIdFor(Payroll::class);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(AgentService::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_items');
    }
};
