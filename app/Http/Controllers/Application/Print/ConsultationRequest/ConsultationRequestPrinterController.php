<?php

namespace App\Http\Controllers\Application\Print\ConsultationRequest;

use App\Charts\TestChart;
use App\Http\Controllers\Controller;
use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use Illuminate\Support\Facades\App;

class ConsultationRequestPrinterController extends Controller
{
    public function printPrivateInvoiceByDate($id)
    {
        $consultationRequest = ConsultationRequest::find($id);
        $categories = CategoryTarif::all();
        $currency='CDF';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.requtests.print-consultation-request-private-invoice',
            compact([
                'consultationRequest',
                'categories','currency'
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }
}
