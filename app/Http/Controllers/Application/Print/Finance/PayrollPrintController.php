<?php

namespace App\Http\Controllers\Application\Print\Finance;

use App\Http\Controllers\Controller;
use App\Models\CategorySpendMoney;
use App\Models\Currency;
use App\Models\Payroll;
use App\Models\PayrollSource;
use App\Repositories\Payroll\GetPayrollRepository;
use Illuminate\Support\Facades\App;

class PayrollPrintController extends Controller
{
    public function printPayroll($id)
    {
        $payroll = Payroll::find($id);
        $payroll->is_valided = true;
        $payroll->update();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.finance.payroll.print-payroll',
            compact([
                'payroll'
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }
    public function printPayrollByDate(
        string $date,
        int $source,
        int $category,
        int $currency
    ) {

        $source == 'null' ? null : $source;
        $category == 'null' ? null : $category;
        $currency == 'null' ? null : $currency;
        $payrolls = GetPayrollRepository::getPayrollBydate($date, $source, $category, $currency);
        $total_cdf = GetPayrollRepository::getTotalPayrollByDate($date, Currency::CDF);
        $total_usd = GetPayrollRepository::getTotalPayrollByDate($date, Currency::USD);
        $categoryData = CategorySpendMoney::find($category);
        $sourceData = PayrollSource::find($source);
        $currencyData = Currency::find($currency);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.finance.payroll.print-payroll-by-date',
            compact([
                'payrolls', 'date', 'total_cdf', 'total_usd', 'currencyData', 'categoryData', 'sourceData'
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }

    public function printPayrollByMonth(
        string $month,
        int $source,
        int $category,
        int $currency
    ) {

        $source=='null'?null:$source;
        $category=='null'?null:$category;
        $currency == 'null' ? null : $currency;
        $payrolls = GetPayrollRepository::getPayrollByMonth($month, $source, $category, $currency);
        $total_cdf = GetPayrollRepository::getTotalPayrollByMonth($month, Currency::CDF);
        $total_usd = GetPayrollRepository::getTotalPayrollByMonth($month, Currency::USD);
        $categoryData = CategorySpendMoney::find($category);
        $sourceData = PayrollSource::find($source);
        $currencyData=Currency::find($currency);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.finance.payroll.print-payroll-by-month',
            compact([
                'payrolls', 'month', 'total_cdf', 'total_usd', 'currencyData', 'categoryData', 'sourceData'
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }
}
