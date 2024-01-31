<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailOutpatientBill extends Model
{
    use HasFactory;
    protected $fillable=['amount_cdf','amount_usd', 'outpatient_bill_id'];
    /**
     * Get the outpatientBill that owns the DetailOutpatientBill
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function outpatientBill(): BelongsTo
    {
        return $this->belongsTo(OutpatientBill::class, 'outpatient_bill_id');
    }
}
