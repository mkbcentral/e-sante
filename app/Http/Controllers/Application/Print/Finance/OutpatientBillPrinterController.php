<?php

namespace App\Http\Controllers\Application\Print\Finance;

use App\Http\Controllers\Controller;
use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use App\Models\Hospital;
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

    public function pridntAllConsultationRequestBydate($subscriptionId, $date)
    {
        $year = date('Y');
        $categories = CategoryTarif::all();
        $currency = 'CDF';
        $consultationRequests = ConsultationRequest::query()
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.subscription_id', $subscriptionId)
            ->orderBy('consultation_requests.created_at', 'ASC')
            ->select('consultation_requests.*')
            ->with(['consultationSheet.subscription'])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->whereDate('consultation_requests.created_at', $date)
            ->whereYear('consultation_requests.created_at', $year)
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('prints.requtests.print-consultation-request-private-invoice-all', compact(['consultationRequests', 'categories', 'currency']));
        return $pdf->stream();
    }

    public function pridntAllConsultationRequestByMonth($subscriptionId, $month)
    {
        $year = date('Y');
        $categories = CategoryTarif::all();
        $currency = 'CDF';
        $consultationRequests = ConsultationRequest::query()
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.subscription_id', $subscriptionId)
            ->orderBy('consultation_requests.created_at', 'ASC')
            ->select('consultation_requests.*')
            ->with(['consultationSheet.subscription'])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->whereMonth('consultation_requests.created_at', $month)
            ->whereYear('consultation_requests.created_at', $year)
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('prints.requtests.print-consultation-request-private-invoice-all', compact(['consultationRequests', 'categories', 'currency']));
        return $pdf->stream();
    }

    public function pridntAllConsultationRequestBetweenDate(
        $subscriptionId,
        string $startDate,
        string $endDate,
    ) {
        $year = date('Y');
        $categories = CategoryTarif::all();
        $currency = 'CDF';
        $consultationRequests = ConsultationRequest::query()
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.subscription_id', $subscriptionId)
            ->orderBy('consultation_requests.created_at', 'ASC')
            ->select('consultation_requests.*')
            ->with(['consultationSheet.subscription'])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->whereBetween('consultation_requests.created_at', [$startDate, $endDate])
            ->whereYear('consultation_requests.created_at', $year)
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('prints.requtests.print-consultation-request-private-invoice-all', compact(['consultationRequests', 'categories', 'currency']));
        return $pdf->stream();
    }
}
