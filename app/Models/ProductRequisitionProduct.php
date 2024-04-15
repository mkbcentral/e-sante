<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductRequisitionProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_requisition_id',
        'quantity',
        'quantity_available'
    ];
    /**
     * Get the product that owns the ProductRequisitionProduct
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the productRequinistion that owns the ProductRequisitionProduct
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productRequinistion(): BelongsTo
    {
        return $this->belongsTo(ProductRequisition::class, 'product_requisition_id');
    }
}
