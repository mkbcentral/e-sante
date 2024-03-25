<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payroll extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'description',
        'category_spend_money_id',
        'hospital_id',
        'currency_id',
        'user_id',
        'payroll_source_id',
    ];

    /**
     * Get the categorySpendMoney that owns the Payroll
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorySpendMoney(): BelongsTo
    {
        return $this->belongsTo(CategorySpendMoney::class, 'category_spend_money_id');
    }
    /**
     * Get the hospital that owns the Payroll
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    /**
     * Get the user that owns the Payroll
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the payRollItems for the Payroll
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payRollItems(): HasMany
    {
        return $this->hasMany(PayrollItem::class);
    }

    public function getCouterPayRollItems(): int|float
    {
        return $this->payRollItems->count();
    }

    /**
     * Get the currency that owns the Payroll
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * Get the payrollSource that owns the Payroll
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollSource(): BelongsTo
    {
        return $this->belongsTo(PayrollSource::class, 'payroll_source_id');
    }

    public function getPayrollTotalAmount():int|float
    {
        $total=0;
        foreach ($this->payRollItems as $payRoll) {
           $total+=$payRoll->amount;
        }

        return $total;
    }

    public function getNumberAttribute($val):string{
        return 'E-'.$val.'-PS';
    }
}
