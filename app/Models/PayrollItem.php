<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollItem extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'amount',
        'is_valided',
        'user_id',
        'payroll_id',
        'agent_service_id'
    ];

    /**
     * Get the user that owns the PayrollItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the agentService that owns the PayrollItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agentService(): BelongsTo
    {
        return $this->belongsTo(AgentService::class, 'agent_service_id');
    }
}
