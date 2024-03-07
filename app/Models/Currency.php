<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    const DEFAULT_CURRENCY='CDF';
    const DEFAULT_ID_CURRENCY = 1;
    protected $fillable=['name'];

}
