<?php

namespace App\Repositories\Sheet\Get;

use App\Models\ConsultationRequest;

class GetConsultationRequestionAmountRepository
{
    public static function getTotalByDate(
        int    $idSubscription,
        string|null $q,
        int|null    $source_id,
        bool|null    $is_hospitalized,
        string $date,
        string|null $currency
    ): int|float {
        $filters = self::filters(
            $idSubscription,
            $q,
            $source_id,
            $is_hospitalized
        );
        $total = 0;
        $consultationRequests = ConsultationRequest::query()
            ->reusable($filters)
            ->whereDate('consultation_requests.created_at', $date)
            ->get();
        foreach ($consultationRequests as $consultationRequest) {
            if ($currency == 'USD') {
                $total += $consultationRequest->getTotalInvoiceUSD();
            } else {
                $total += $consultationRequest->getTotalInvoiceCDF();
            }
        }
        return $total;
    }

    public static function getTotalByMonth(
        int    $idSubscription,
        string|null $q,
        int|null    $source_id,
        bool|null    $is_hospitalized,
        string $month,
        string $year,
        string|null $currency
    ): int|float {
        $filters = self::filters(
            $idSubscription,
            $q,
            $source_id,
            $is_hospitalized
        );
        $total = 0;
        $consultationRequests = ConsultationRequest::query()
            ->reusable($filters)
            ->whereMonth('consultation_requests.created_at', $month)
            ->whereYear('consultation_requests.created_at', $year)
            ->get();
        foreach ($consultationRequests as $consultationRequest) {
            if ($currency == 'USD') {
                $total += $consultationRequest->getTotalInvoiceUSD();
            } else {
                $total += $consultationRequest->getTotalInvoiceCDF();
            }
        }
        return $total;
    }
    public static function getTotalPeriod(
        int    $idSubscription,
        string|null $q,
        int|null    $source_id,
        bool|null    $is_hospitalized,
        string $startDate,
        string $endDate,
        string  $currency
    ): int|float {
        $filters = self::filters(
            $idSubscription,
            $q,
            $source_id,
            $is_hospitalized
        );
        $total = 0;
        $consultationRequests = ConsultationRequest::query()
            ->reusable($filters)
            ->whereBetween('consultation_requests.created_at', [$startDate, $endDate])
            ->get();
        foreach ($consultationRequests as $consultationRequest) {
            if ($currency == 'USD') {
                $total += $consultationRequest->getTotalInvoiceUSD();
            } else {
                $total += $consultationRequest->getTotalInvoiceCDF();
            }
        }
        return $total;
    }
    private static function filters(
        int    $idSubscription,
        string|null $q,
        int |null   $source_id,
        bool|null    $is_hospitalized,
    ): array {
        return [
            'id_subscription' => $idSubscription,
            'q' => $q,
            'source_id' => $source_id,
            'is_hospitalized' => $is_hospitalized,
        ];
    }
}
