<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'butch_number','initial_quantity','name',
        'price','expiration_date','product_family_id','product_category_id',
        'hospital_id', 'is_specialty', 'source_id'
    ];

    protected $casts = [
        'expiration_date' => 'datetime'
    ];
    public function getExpirationDateAttribute($value): string
    {
        return Carbon::parse($value)->toFormattedDate();
    }

    public function productInvoices(): BelongsToMany
    {
        return $this->belongsToMany(ProductInvoice::class)->withPivot('id', 'qty');
    }

    /**
     * Get all of the productSupplyProducts for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productSupplyProducts(): HasMany
    {
        return $this->hasMany(productSupplyProduct::class);
    }
}
