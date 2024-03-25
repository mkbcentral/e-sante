<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PayrollSource extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'hospital_id'];

    /**
     * Get all of the payroll for the PayrollSource
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }
}
