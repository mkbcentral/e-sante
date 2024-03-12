<?php

namespace App\Http\Controllers\Application\Print\ConsultationRequest;

use App\Http\Controllers\Controller;
use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Models\Subscription;
use Illuminate\Support\Facades\App;

class ConsultationRequestPrinterController extends Controller
{
    public function printPrivateInvoiceByDate($id)
    {
        $consultationRequest = ConsultationRequest::find($id);
        $categories = CategoryTarif::all();
        $currency = 'CDF';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.requtests.print-consultation-request-private-invoice',
            compact([
                'consultationRequest',
                'categories', 'currency'
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }

    public function printListInvoicesByMonth($subscriptionId, $month){
        $year = date('Y');
        $subscription = Subscription::find($subscriptionId);
        $consultationRequests = ConsultationRequest::query()
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.subscription_id', $subscriptionId)
            ->orderBy('consultation_requests.id', 'ASC')
            ->select('consultation_requests.*')
            ->with(['consultationSheet.subscription'])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->whereMonth('consultation_requests.created_at', $month)
            ->whereYear('consultation_requests.created_at', $year)
            ->get();
        $pdf = App::make('dompdf.wrapper');

        $pdf->loadView(
            'prints.requtests.print-list-invoices-by-month',
            compact(['consultationRequests', 'subscription', 'year', 'month'])
        );
        return $pdf->stream();
    }

    public function printConsultationRequestHasNotShippingTicket($subscriptionId, $month)
    {
        $year = date('Y');
        $subscription=Subscription::find($subscriptionId);
        $consultationRequests = ConsultationRequest::query()
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.subscription_id', $subscriptionId)
            ->where('consultation_requests.has_a_shipping_ticket', false)
            ->orderBy('consultation_requests.id', 'ASC')
            ->select('consultation_requests.*')
            ->with(['consultationSheet.subscription'])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->whereMonth('consultation_requests.created_at', $month)
            ->whereYear('consultation_requests.created_at', $year)
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('prints.requtests.print-consultation-requests-has-not-shipping-ticket',
            compact(['consultationRequests','subscription','year'])
        );
        return $pdf->stream();
    }
}
