<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductSupply extends Model
{
    use HasFactory;
    protected $fillable=['code','user_id'];


    public function getCodeAttribute($value):string
    {
        return 'AP-'.$value.'-PS';
    }

    /**
     * Get the user associated with the ProductSupply
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user_id');
    }

    /**
     * Get all of the productSupplyProducts for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productSupplyProducts(): HasMany
    {
        return $this->hasMany(ProductSupplyProduct::class);
    }
}
