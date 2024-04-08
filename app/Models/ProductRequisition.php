<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductRequisition extends Model
{
    use HasFactory;

    protected $fillable=['number', 'agent_service_id', 'hospital_id','user_id', 'source_id','created_at'];

    public function getNumberAttribute($value): string
    {
        return 'RQ-'.$value.'-PS';
    }

    /**
     * Get the user that created the ProductRequisition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

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

    /**
     * Get all of the productRequistionProducts for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productRequistionProducts(): HasMany
    {
        return $this->hasMany(ProductRequisitionProduct::class);
    }

    public function getProductAmpout(){
        $amount=0;
        foreach ($this->productRequistionProducts as $productRequistionProduct ) {
            $amount+=$productRequistionProduct->product->price* $productRequistionProduct->quantity;
        }

        return $this->is_valided==false?0: $amount;
    }


}
