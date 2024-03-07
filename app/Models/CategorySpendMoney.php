<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategorySpendMoney extends Model
{
    use HasFactory;

    protected $fillable=['name','hospital_id'];

    /**
     * Get all of the payRolles for the CategorySpendMoney
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    /**
     * @return HasMany
     */
    public function payRolles(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }

    /**
     * Get all of the expenseVouchers for the CategorySpendMoney
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenseVouchers(): HasMany
    {
        return $this->hasMany(ExpenseVoucher::class);
    }
}
