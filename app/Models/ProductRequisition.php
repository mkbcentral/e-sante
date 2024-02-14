<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductRequisition extends Model
{
    use HasFactory;

    protected $fillable=['number', 'agent_service_id', 'hospital_id', 'source_id'];

    /**
     * Get the agentService that owns the ProductRequisition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agentService(): BelongsTo
    {
        return $this->belongsTo(AgentService::class, 'agent_service_id');
    }

    /**
     * Get the hospital that owns the ProductRequisition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    /**
     * Get the source that owns the ProductRequisition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

}
