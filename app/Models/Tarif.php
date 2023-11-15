<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarif extends Model
{
    protected $fillable=['name','abbreviation','price_private','subscriber_price','category_tarif_id'];
    use HasFactory;
    public function categoryTarif():BelongsTo{
        return $this->belongsTo(CategoryTarif::class,'category_tarif_id');
    }
}
