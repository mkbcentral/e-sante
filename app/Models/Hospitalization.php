<?php

namespace App\Models;

use App\Repositories\Rate\RateRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospitalization extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price_private', 'subscriber_price', 'hospital_id'];
    public function getAmountPrivateCDF(): int|float
    {
        return $this->price_private * RateRepository::getCurrentRate()->rate;
    }
    public function getAmountSuscriberCDF(): int|float
    {
        return $this->subscriber_price * RateRepository::getCurrentRate()->rate;
    }
}
