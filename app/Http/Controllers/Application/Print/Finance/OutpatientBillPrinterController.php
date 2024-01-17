<?php

namespace App\Http\Controllers\Application\Print\Finance;

use App\Http\Controllers\Controller;
use App\Models\CategoryTarif;
use App\Models\OutpatientBill;
use App\Repositories\OutpatientBill\GetOutpatientRepository;
use Illuminate\Support\Facades\App;

class OutpatientBillPrinterController extends Controller
{
    public function printOutPatientBill($outpatientBillId,$currency){

        $outpatientBill=OutpatientBill::find($outpatientBillId);
        $categories=CategoryTarif::all();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.finance.bill.print-outpatient-bill',compact([
                'outpatientBill',
                'currency', 'categories'
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }
}
