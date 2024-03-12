<?php

namespace App\Http\Controllers\Application\Print\Finance;

use App\Http\Controllers\Controller;
use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Models\OutpatientBill;
use App\Repositories\OutpatientBill\GetOutpatientRepository;
use App\Repositories\Sheet\Get\GetConsultationRequestionAmountRepository;
use App\Repositories\Sheet\Get\GetConsultationRequestRepository;
use DateTime;
use Illuminate\Support\Facades\App;

class OutpatientBillPrinterController extends Controller
{
    public function printOutPatientBill($outpatientBillId, $currency)
    {
        $outpatientBill = OutpatientBill::find($outpatientBillId);
        $outpatientBill->is_validated = true;
        $outpatientBill->update();
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

    public function printRapportByDateOutpatientBill($date,$date_versement)
    {
        $listBill = GetOutpatientRepository::getOutpatientPatientByDate($date);
        $consultationRequests = GetConsultationRequestRepository::getConsultationRequestHospitalizedToBordereau();
        $total_cdf = GetOutpatientRepository::getTotalBillByDateGroupByCDF($date);
        $total_usd = GetOutpatientRepository::getTotalBillByDateGroupByUSD($date);
        $total_cons_usd = GetConsultationRequestionAmountRepository::getTotalHospitalizeUSD();
        $total_cons_cdf = GetConsultationRequestionAmountRepository::getTotalHospitalizeCDF();
        $dateToMorrow =(new DateTime($date_versement))->format('d/m/Y');

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('prints.finance.bill.print-repport-outpatient-by-date', compact(
            [
                'listBill', 'date', 'total_cdf', 'total_usd', 'consultationRequests',
                'total_cons_usd', 'total_cons_cdf', 'dateToMorrow'
            ]
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
            ->orderBy('consultation_requests.request_number', 'ASC')
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
            ->orderBy('consultation_requests.request_number', 'ASC')
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
            ->join(
                'consultation_sheets',
                'consultation_sheets.id',
                'consultation_requests.consultation_sheet_id'
            )
            ->where('consultation_sheets.subscription_id', $subscriptionId)
            ->select('consultation_requests.*')
            ->with(['consultationSheet.subscription'])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->whereBetween('consultation_requests.created_at', [$startDate, $endDate])
            ->whereYear('consultation_requests.created_at', $year)
            ->orderBy('consultation_requests.request_number', 'ASC')
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.requtests.print-consultation-request-private-invoice-all',
            compact(['consultationRequests', 'categories', 'currency'])
        );
        return $pdf->stream();
    }
}
