<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class ProductInvoice extends Model
{
    use HasFactory;
    protected $fillable=['number','client','user_id','hospital_id', 'is_valided'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('id', 'qty');
    }
    //Get total by invoice
    public function getTotalInvoice():int|float{
        $total=0;
        if ($this->products->isEmpty()) $total;

        foreach($this->products as $product){
            $total+=$product->price*$product->pivot->qty;
        }
        return $total;
    }

    /**
     * Get the user that owns the ProductInvoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Get formatted number attribute
    public function getNumberAttribute($value)
    {
        return 'A-'.$value.'-PS';
    }


}
