<?php

namespace App\Repositories\OutpatientBill;

use App\Models\OutpatientBill;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetOutpatientRepository
{


    public static function getOutpatientPatientByDate(string $date): Collection
    {
        return OutpatientBill::orderBy('created_at', 'DESC')
            ->whereDate('created_at', $date)
            ->get();
    }

    public static function getOutpatientPatientByMonth(string $month): Collection
    {
        return OutpatientBill::orderBy('created_at', 'DESC')
            ->whereMonth('created_at', $month)
            ->get();
    }

    /**
     * getTotalBillByDateUSD
     * @param mixed $date
     * @return int|float
     */
    public static function getTotalBillByDateUSD(string $date): int|float
    {
        $total = 0;
        $cons_total = 0;
        $outpatientBills = OutpatientBill::whereDate('created_at', $date)
            ->get();
        foreach ($outpatientBills as $outpatientBill) {
            foreach ($outpatientBill->tarifs as $tarif) {
                $total += $tarif->price_private * $tarif->pivot->qty;
            }
            $cons_total += $outpatientBill->consultation->price_private;
        }
        return $total + $cons_total;
    }
    /**
     * getTotalBillByDateCDF
     * @param mixed $date
     * @return int|float
     */
    public static function getTotalBillByDateCDF(string $date): int|float
    {
        $total = 0;
        $cons_total = 0;
        $outpatientBills = OutpatientBill::whereDate('created_at', $date)
            ->with(['consultation'])
            ->get();
        foreach ($outpatientBills as $outpatientBill) {
            foreach ($outpatientBill->tarifs as $tarif) {
                $total += (($tarif->price_private * $tarif->pivot->qty) * $outpatientBill->rate->rate);
            }
            $cons_total += $outpatientBill->consultation->price_private * $outpatientBill->rate->rate;
        }
        return $total + $cons_total;
    }
    /**
     * getTotalBillByMonthUSD
     * @param mixed $$month
     * @return int|float
     */
    public static function getTotalBillByMonthUSD(string $month): int|float
    {
        $total = 0;
        $cons_total = 0;
        $outpatientBills = OutpatientBill::whereMonth('created_at', $month)
            ->get();
        foreach ($outpatientBills as $outpatientBill) {
            foreach ($outpatientBill->tarifs as $tarif) {
                $total += $tarif->price_private * $tarif->pivot->qty;
            }
            $cons_total += $outpatientBill->consultation->price_private;
        }
        return $total + $cons_total;
    }

    /**
     * getTotalBillByMonthCDF
     * @param mixed $month
     * @return int|float
     */
    public static function getTotalBillByMonthCDF(string $date): int|float
    {
        $total = 0;
        $cons_total = 0;
        $outpatientBills = OutpatientBill::whereMonth('created_at', $date)
            ->with(['consultation'])
            ->get();
        foreach ($outpatientBills as $outpatientBill) {
            foreach ($outpatientBill->tarifs as $tarif) {
                $total += (($tarif->price_private * $tarif->pivot->qty) * $outpatientBill->rate->rate);
            }
            $cons_total += $outpatientBill->consultation->price_private * $outpatientBill->rate->rate;
        }
        return $total + $cons_total;
    }

    public static function getOutpatientBillTarifItemByCategoryTarif(int $outpatientBillId, int $categoryTarifId): Collection
    {
        return DB::table('outpatient_bill_tarif')
            ->join('tarifs', 'tarifs.id', 'outpatient_bill_tarif.tarif_id')
            ->join('category_tarifs', 'category_tarifs.id', 'tarifs.category_tarif_id')
            ->where('outpatient_bill_tarif.outpatient_bill_id', $outpatientBillId)
            ->where('category_tarifs.id', $categoryTarifId)
            ->select('outpatient_bill_tarif.*', 'tarifs.name', 'tarifs.abbreviation', 'tarifs.price_private')
            ->get();
    }


    /**
     * getTotalBillByDate group by currency CDF
     * @param mixed $date
     * @return int|float
     */
    public static function getTotalBillByDateGroupByCDF(string $date): int|float
    {
        $total = 0;
        $cons_total = 0;
        $total_detail=0;
        $outpatientBills = OutpatientBill::whereDate('created_at', $date)
            ->with(['consultation'])
            ->get();
        foreach ($outpatientBills as $outpatientBill) {
            if ($outpatientBill->currency && $outpatientBill->currency->name=='CDF') {
                $total += $outpatientBill->getTotalOutpatientBillCDF();
            }else{
                $total_detail+=$outpatientBill?->detailOutpatientBill?->amount_cdf;
            }
        }
        return $total + $total_detail;
    }
    /**
     * getTotalBillByDate group by currency USD
     * @param mixed $date
     * @return int|float
     */
    public static function getTotalBillByDateGroupByUSD(string $date): int|float
    {
        $total = 0;
        $cons_total = 0;
        $total_detail = 0;
        $outpatientBills = OutpatientBill::whereDate('created_at', $date)
            ->with(['consultation'])
            ->get();
        foreach ($outpatientBills as $outpatientBill) {
            if ($outpatientBill->currency && $outpatientBill->currency->name == 'USD') {
                $total += $outpatientBill->getTotalOutpatientBillUSD();
            } else {
                $total_detail += $outpatientBill?->detailOutpatientBill?->amount_usd;
            }
        }
        return $total + $total_detail;
    }

    /**
     * getTotalBillByMonth group by currency CDF
     * @param mixed $month
     * @return int|float
     */
    public static function getTotalBillByMonthGroupByCDF(string $month): int|float
    {
        $total = 0;
        $cons_total = 0;
        $total_detail = 0;
        $outpatientBills = OutpatientBill::whereMonth('created_at', $month)
            ->with(['consultation'])
            ->get();
        foreach ($outpatientBills as $outpatientBill) {
            if ($outpatientBill->currency && $outpatientBill->currency->name == 'CDF') {
                $total += $outpatientBill->getTotalOutpatientBillCDF();
            } else {
                $total_detail += $outpatientBill?->detailOutpatientBill?->amount_cdf;
            }
        }
        return $total + $total_detail;
    }

    /**
     * getTotalBillByMonth group by currency USD
     * @param mixed $month
     * @return int|float
     */
    public static function getTotalBillByMonthGroupByUSD(string $month): int|float
    {
        $total = 0;
        $cons_total = 0;
        $total_detail = 0;
        $outpatientBills = OutpatientBill::whereMonth('created_at', $month)
            ->with(['consultation'])
            ->get();
        foreach ($outpatientBills as $outpatientBill) {
            if ($outpatientBill->currency && $outpatientBill->currency->name == 'USD') {
                $total += $outpatientBill->getTotalOutpatientBillUSD();
            } else {
                $total_detail += $outpatientBill?->detailOutpatientBill?->amount_usd;
            }
        }
        return $total + $total_detail;
    }

}
