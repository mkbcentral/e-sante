<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'butch_number', 'initial_quantity', 'name',
        'price', 'expiration_date', 'product_family_id', 'product_category_id',
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

    public function getTotalInputsByService():int|float
    {
        $quantity=0;
        $inputs = ProductSupplyProduct::join('products', 'products.id', 'product_supply_products.product_id')
            ->join('product_supplies', 'product_supplies.id', 'product_supply_products.product_supply_id')
            ->join('users', 'users.id', 'product_supplies.user_id')
            ->select('product_supply_products.*', 'products.name as product_name')
            ->with(['product'])
            ->where('users.agent_service_id', Auth::user()->agentService->id)
            ->where('product_supply_products.product_id', $this->id)
            ->get();

        foreach ($inputs as $input) {
            $quantity+=$input->quantity;
        }
        return $quantity;
    }

    public function TotalOutputsByService()
    {
    }
}
