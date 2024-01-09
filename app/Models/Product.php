<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'butch_number','initial_quantity','name',
        'price','expiration_date','product_family_id','product_category_id',
        'hospital_id', 'is_specialty'
    ];
    public function getExpirationDate($value): string
    {
        return Carbon::parse($value)->toFormattedDate();
    }
    protected $casts=['expiration_date'=>'datetime'];

    public function productInvoices(): BelongsToMany
    {
        return $this->belongsToMany(ProductInvoice::class)->withPivot('id', 'qty');
    }
}
