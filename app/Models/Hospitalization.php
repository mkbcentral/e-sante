<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospitalization extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price_private', 'subscriber_price', 'hospital_id'];
}
