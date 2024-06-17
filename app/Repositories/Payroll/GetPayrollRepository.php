<?php

namespace App\Repositories\Payroll;

use App\Models\Hospital;
use App\Models\Payroll;

class GetPayrollRepository
{

    /**
     * Get list payroll by date
     */
    public static function getPayrollBydate(
        $date_filter,
        ?int $source = null,
        ?int $category = null,
        ?int $currency = null
    ) {
        return Payroll::query()
            ->when($source, function ($query, $source) {
                return $query->where('payroll_source_id', $source);
            })
            ->when($currency, function ($query, $currency) {
                return $query->where('currency_id', $currency);
            })
            ->when($category, function ($query, $category) {
                return $query->where('category_spend_money_id', $category);
            })
            ->whereDate('created_at', $date_filter)
            ->get();
    }

    /**et list payroll by month
     * $source,$category, $currency_id;
     */
    public static function getPayrollByMonth(
        string $month,
        ?int $source = null,
        ?int $category = null,
        ?int $currency = null
    ) {
        return Payroll::query()
            ->when($source, function ($query, $source) {
                return $query->where('payroll_source_id', $source);
            })
            ->when($currency, function ($query, $currency) {
                return $query->where('currency_id', $currency);
            })
            ->when($category, function ($query, $category) {
                return $query->where('category_spend_money_id', $category);
            })
            ->whereMonth('created_at', $month)
            ->where('is_valided', true)
            ->where('hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->orderBy('created_at', 'ASC')
            ->with(['payrollSource', 'currency'])
            ->get();
    }

    //get total payrolls by date for currency usd
    public static function getTotalPayrollByDate(string  $date_filter, string $currency)
    {
        return Payroll::query()
            ->join('payroll_items', 'payrolls.id', '=', 'payroll_items.payroll_id')
            ->whereDate('payrolls.created_at', $date_filter)
            ->where('payrolls.currency_id', $currency)
            ->where('payrolls.is_valided', true)
            ->sum('payroll_items.amount');
    }
    //get total payrolls by month for currency usd
    public static function getTotalPayrollByMonth(string $month, $currency)
    {
        return Payroll::query()
            ->join('payroll_items', 'payrolls.id', '=', 'payroll_items.payroll_id')
            ->whereMonth('payrolls.created_at', $month)
            ->where('payrolls.currency_id', $currency)
            ->where('payrolls.is_valided', true)
            ->sum('payroll_items.amount');
    }
}
