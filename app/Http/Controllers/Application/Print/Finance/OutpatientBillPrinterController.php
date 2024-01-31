<?php

namespace App\Http\Controllers\Application\Print\Finance;

use App\Http\Controllers\Controller;
use App\Models\CategoryTarif;
use App\Models\OutpatientBill;
use App\Repositories\OutpatientBill\GetOutpatientRepository;
use Illuminate\Support\Facades\App;

class OutpatientBillPrinterController extends Controller
{
    public function printOutPatientBill($outpatientBillId, $currency)
    {

        $outpatientBill = OutpatientBill::find($outpatientBillId);
        $categories = CategoryTarif::all();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.finance.bill.print-outpatient-bill',
            compact([
                'outpatientBill',
                'currency', 'categories'
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }

    public function printRapportByDateOutpatientBill($date)
    {
        $listBill = GetOutpatientRepository::getOutpatientPatientByDate($date);
        $total_cdf = GetOutpatientRepository::getTotalBillByDateGroupByCDF($date);
        $total_usd = GetOutpatientRepository::getTotalBillByDateGroupByUSD($date);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('prints.finance.bill.print-repport-outpatient-by-date', compact(
            ['listBill', 'date', 'total_cdf', 'total_usd']
        ));
        return $pdf->stream();
    }

    public function printRapportByMonthOutpatientBill($month)
    {
        $listBill = GetOutpatientRepository::getOutpatientPatientByMonth($month);
        $total_cdf = GetOutpatientRepository::getTotalBillByMonthGroupByCDF($month);
        $total_usd = GetOutpatientRepository::getTotalBillByMonthGroupByUSD($month);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('prints.finance.bill.print-repport-outpatient-by-month', compact(
            ['listBill', 'month', 'total_cdf', 'total_usd']
        ));
        return $pdf->stream();
    }
}
