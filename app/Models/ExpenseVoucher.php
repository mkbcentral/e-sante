<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'description',
        'amount',
        'is_valided',
        'agent_service_id',
        'category_spend_money'
    ];

    /**
     * Get the agentService that owns the ExpenseVoucher
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agentService(): BelongsTo
    {
        return $this->belongsTo(AgentService::class, 'agent_service_id');
    }

    /**
     * Get the categorySpendMoney that owns the ExpenseVoucher
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorySpendMoney(): BelongsTo
    {
        return $this->belongsTo(CategorySpendMoney::class, 'category_spend_money');
    }
}
