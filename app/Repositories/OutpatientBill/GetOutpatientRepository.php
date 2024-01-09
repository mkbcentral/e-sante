<?php

namespace App\Repositories\OutpatientBill;

use App\Models\OutpatientBill;
use Illuminate\Support\Collection;

class GetOutpatientRepository
{


    public static function getOutpatientPatientByDate(string $date):Collection
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
}
