<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSupplyProduct extends Model
{
    use HasFactory;

    protected $fillable=['quantity','product_id', 'product_supply_id'];

    /**
     * Get the product that owns the ProductSupplyProduct
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    /**
     * Get the productSupply that owns the ProductSupplyProduct
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productSupply(): BelongsTo
    {
        return $this->belongsTo(ProductSupply::class, 'product_supply_id');
    }
}
