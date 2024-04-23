<?php

namespace App\Repositories\Sheet\Get;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Repositories\Rate\RateRepository;

class ManageConsultationRequestRepository
{
    //close consultation request
    public static function closeConsultationRequest(
        $selectedIndex,/
        $month_name,
        $year
    ): void {
        $consultationRequests
            = ConsultationRequest::join(
                'consultation_sheets',
                'consultation_sheets.id',
                'consultation_requests.consultation_sheet_id'
            )
            ->where('consultation_sheets.subscription_id', $selectedIndex)
            ->select('consultation_requests.*')
            ->with(['consultationSheet.subscription'])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->whereMonth('consultation_requests.created_at', $month_name)
            ->whereYear('consultation_requests.created_at', $year)
            ->orderBy('consultation_requests.id', 'ASC')
            ->get();
        foreach ($consultationRequests as $consultationRequest) {
            if ($consultationRequest->is_printed == true) {
                $consultationRequest->is_printed = false;
                $consultationRequest->is_finished = false;
            } else {
                $consultationRequest->is_printed = true;
                $consultationRequest->is_finished = true;
            }
            $consultationRequest->update();
        }
    }
    //Delete consultation request
    public static function deleteConsultationRequest(ConsultationRequest $consultationRequest): void
    {
        foreach ($consultationRequest->tarifs as $tarif) {
            MakeQueryBuilderHelper::deleteWithKey('consultation_request_tarif', 'consultation_request_id', $consultationRequest->id);
        }
        foreach ($consultationRequest->products as $product) {
            MakeQueryBuilderHelper::deleteWithKey('consultation_request_product', 'consultation_request_id', $consultationRequest->id);
        }
        foreach ($consultationRequest->consultationRequestHospitalizations as $hospitalization) {
            MakeQueryBuilderHelper::deleteWithKey('consultation_request_hospitalizations', 'consultation_request_id', $consultationRequest->id);
        }
        foreach ($consultationRequest->consultationRequestNursings as $nursing) {
            MakeQueryBuilderHelper::deleteWithKey('consultation_request_nersings', 'consultation_request_id', $consultationRequest->id);
        }
        $consultationRequest->delete();
    }

    //Fix numerotation
    public static function fixNumerotation(
        $selectedIndex,
        $month_name,
        $year
    ): void {
        $consultationRequestList
            = ConsultationRequest::join(
                'consultation_sheets',
                'consultation_sheets.id',
                'consultation_requests.consultation_sheet_id'
            )
            ->where('consultation_sheets.subscription_id', $selectedIndex)
            ->select('consultation_requests.*')
            ->with(['consultationSheet.subscription'])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->whereMonth('consultation_requests.created_at', $month_name)
            ->whereYear('consultation_requests.created_at', $year)
            ->orderBy('consultation_requests.id', 'ASC')
            ->get();
        foreach ($consultationRequestList as $index => $consultationRequest) {
            $consultationRequest = ConsultationRequest::find($consultationRequest->id);
            $consultationRequest->request_number = $index + 1;
            $consultationRequest->update();
        }
    }

    //Fix numerotation
    public static function fixRate(
        $selectedIndex,
        $month_name,
        $year
    ): void {
        $consultationRequestList
            = ConsultationRequest::join(
                'consultation_sheets',
                'consultation_sheets.id',
                'consultation_requests.consultation_sheet_id'
            )
            ->where('consultation_sheets.subscription_id', $selectedIndex)
            ->select('consultation_requests.*')
            ->with(['consultationSheet.subscription'])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->whereMonth('consultation_requests.created_at', $month_name)
            ->whereYear('consultation_requests.created_at', $year)
            ->get();
        foreach ($consultationRequestList as $index => $consultationRequest) {
            $consultationRequest = ConsultationRequest::find($consultationRequest->id);
            $consultationRequest->rate_id = RateRepository::getCurrentRate()->id;
            $consultationRequest->update();
        }
    }
}
