<?php

namespace App\Http\Controllers\Report\Finance;

use App\Http\Controllers\Controller;
use App\Repositories\OutpatientBill\ReportOutpatientRepository;
use Illuminate\Support\Facades\App;

class OutpatientFinanceReportController extends Controller
{
    public function printFinanceSynthesisMonth(
        string $month,
        $year
    ) {
        $bills = ReportOutpatientRepository::getOuPatientBillListWithCurrencyAmountByMonth(
            $month,
            $year
        );

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.tarifs.print-list-price',
            compact([
                'categoryTarif',
                'categoryTarifs',
                'type_data',
                'consultations',
                'hospitalizations'
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }
}
