<?php
namespace App\Repositories\Payroll;

use App\Models\Currency;
use App\Models\Payroll;

class GetPayrollRepository
{
    public static function getPayrollBydate($date_filter)
    {
        return Payroll::query()
            ->whereDate('created_at', $date_filter)
            ->get();
    }

    //get payroll by month
    public static function getPayrollByMonth($month)
    {
        return Payroll::query()
            ->whereMonth('created_at', $month)
            ->get();
    }

    //get total payrolls by date for currency usd
    public static function getTotalPayrollByDateUSD($date_filter)
    {
        return Payroll::query()
            ->join('payroll_items', 'payrolls.id', '=', 'payroll_items.payroll_id')
            ->whereDate('payrolls.created_at', $date_filter)
            ->where('payrolls.currency_id', Currency::USD)
            ->where('payrolls.is_valided', true)
            ->sum('payroll_items.amount');
    }

    //get total payrolls by date for currency cdf
    public static function getTotalPayrollByDateCDF($date_filter)
    {
        return Payroll::query()
            ->join('payroll_items', 'payrolls.id', '=', 'payroll_items.payroll_id')
            ->whereDate('payrolls.created_at', $date_filter)
            ->where('payrolls.currency_id', Currency::CDF)
            ->where('payrolls.is_valided', true)
            ->sum('payroll_items.amount');
    }

    //get total payrolls by month for currency usd
    public static function getTotalPayrollByMonthUSD($month)
    {
        return Payroll::query()
            ->join('payroll_items', 'payrolls.id', '=', 'payroll_items.payroll_id')
            ->whereMonth('payrolls.created_at', $month)
            ->where('payrolls.currency_id', Currency::USD)
            ->where('payrolls.is_valided', true)
            ->sum('payroll_items.amount');
    }

    //get total payrolls by month for currency cdf
    public static function getTotalPayrollByMonthCDF($month)
    {
        return Payroll::query()
            ->join('payroll_items', 'payrolls.id', '=', 'payroll_items.payroll_id')
            ->whereMonth('payrolls.created_at', $month)
            ->where('payrolls.currency_id', Currency::CDF)
            ->where('payrolls.is_valided', true)
            ->sum('payroll_items.amount');
    }
}

?>
