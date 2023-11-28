<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'butch_number','initial_quantity','name',
        'price','expiration_date','product_family_id','product_category_id',
        'hospital_id'
    ];
    public function getExpirationDate($value): string
    {
        return Carbon::parse($value)->toFormattedDate();
    }
    protected $casts=['expiration_date'=>'datetime'];
}
