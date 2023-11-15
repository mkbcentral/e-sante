<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryTarif extends Model
{
    use HasFactory;

    protected  $fillable=['name','hospital_id'];
    public function tarifs():HasMany{
        return  $this->hasMany(Tarif::class,);
    }
}
