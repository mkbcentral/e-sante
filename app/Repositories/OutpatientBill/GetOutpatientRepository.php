<?php

namespace App\Repositories\OutpatientBill;

use App\Enums\RoleType;
use App\Models\OutpatientBill;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GetOutpatientRepository
{

    /**
     * getOutpatientPatientByDate
     * @param mixed $date
     * @return mixed
     */
    public static function getOutpatientPatientByDate(string $date): mixed
    {
        //
        return  Auth::user()->roles->pluck('name')->contains(RoleType::MONEY_BOX) ||
            Auth::user()->roles->pluck('name')->contains(RoleType::EMERGENCY) ?
            OutpatientBill::orderBy('created_at', 'DESC')
            ->whereDate('created_at', $date)
            ->where('user_id', Auth::id())
            ->with(['otherOutpatientBill', 'currency', 'detailOutpatientBill', 'tarifs', 'consultation', 'rate', 'user'])
            ->paginate(25) :
            OutpatientBill::orderBy('created_at', 'DESC')
            ->whereDate('created_at', $date)
            ->where('is_validated', true)
            ->with(['otherOutpatientBill', 'currency', 'detailOutpatientBill', 'tarifs', 'consultation', 'rate', 'user'])
            ->paginate(20);
    }
    /**
     * getOutpatientPatientByMonth
     * @param mixed $month
     * @return mixed
     */
    public static function getOutpatientPatientByMonth(string $month): mixed
    {

        return  Auth::user()->roles->pluck('name')->contains(RoleType::MONEY_BOX) ||
            Auth::user()->roles->pluck('name')->contains(RoleType::EMERGENCY) ?
            OutpatientBill::orderBy('created_at', 'DESC')
            ->whereMonth('created_at', $month)
            ->with(['otherOutpatientBill', 'currency', 'detailOutpatientBill', 'tarifs', 'consultation', 'rate', 'user'])
            ->paginate(10) :
            OutpatientBill::orderBy('created_at', 'DESC')
            ->whereMonth('created_at', $month)
            ->where('is_validated', true)
            ->with(['otherOutpatientBill', 'currency', 'detailOutpatientBill', 'tarifs', 'consultation', 'rate', 'user'])
            ->paginate(10);
    }

    /**
     * getOutpatientBillTarifItemByCategoryTarif
     * @param mixed $outpatientBillId
     * @param mixed $categoryTarifId
     * @return Collection
     */
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
     * getTotalBillByDate 
     * @param mixed $date
     * @return int|float
     */
    public static function getTotalBillByDate(string $date, string $currency): int|float
    {
        $total = 0;
        $cons_total = 0;
        $total_detail = 0;
        if (
            Auth::user()->roles->pluck('name')->contains(RoleType::MONEY_BOX) ||
            Auth::user()->roles->pluck('name')->contains(RoleType::EMERGENCY)
        ) {
            $outpatientBills = OutpatientBill::whereDate('created_at', $date)
                ->where('is_validated', true)
                ->where('user_id', Auth::id())
                ->with(['otherOutpatientBill', 'currency', 'detailOutpatientBill', 'tarifs', 'consultation', 'rate', 'user'])
                ->get();
        } else {
            $outpatientBills = OutpatientBill::whereDate('created_at', $date)
                ->where('is_validated', true)
                ->with(['otherOutpatientBill', 'currency', 'detailOutpatientBill', 'tarifs', 'consultation', 'rate', 'user'])
                ->get();
        }
        foreach ($outpatientBills as $outpatientBill) {
            if ($currency == 'USD') {
                if ($outpatientBill->currency == null) {
                    $total_detail += $outpatientBill?->detailOutpatientBill?->amount_usd;
                } else if ($outpatientBill->currency->name == 'USD') {
                    $total += $outpatientBill->getTotalOutpatientBillUSD() + $outpatientBill?->detailOutpatientBill?->amount_usd;
                }
            } else {
                if ($outpatientBill->currency == null) {
                    $total_detail += $outpatientBill?->detailOutpatientBill?->amount_cdf;
                } else if ($outpatientBill->currency->name == 'CDF') {
                    $total += $outpatientBill->getTotalOutpatientBillCDF();
                }
            }
        }
        return $total + $total_detail;
    }

    /**
     * getTotalBillByMonth
     * @param mixed $month
     * @return int|float
     */
    public static function getTotalBillByMonth(string $month, string $year = '2025', string $currency): int|float
    {
        $total = 0;
        $cons_total = 0;
        if (
            Auth::user()->roles->pluck('name')->contains(RoleType::MONEY_BOX) ||
            Auth::user()->roles->pluck('name')->contains(RoleType::EMERGENCY)
        ) {
            $outpatientBills = OutpatientBill::whereMonth('created_at', $month)
                ->where('is_validated', true)
                ->whereYear('created_at', $year)
                ->where('user_id', Auth::id())
                ->with(['otherOutpatientBill', 'currency', 'detailOutpatientBill', 'tarifs', 'consultation', 'rate', 'user'])
                ->get();
        } else {
            $outpatientBills = OutpatientBill::whereMonth('created_at', $month)
                ->where('is_validated', true)
                ->whereYear('created_at', $year)
                ->with(['otherOutpatientBill', 'currency', 'detailOutpatientBill', 'tarifs', 'consultation', 'rate', 'user'])
                ->get();
        }
        foreach ($outpatientBills as $outpatientBill) {
            if ($currency == 'USD') {
                if ($outpatientBill->currency == null) {
                    $total += $outpatientBill?->detailOutpatientBill?->amount_usd;
                } else if ($outpatientBill->currency->name == 'USD') {
                    $total += $outpatientBill->getTotalOutpatientBillUSD();
                }
            } else {
                if ($outpatientBill->currency == null) {
                    $total += $outpatientBill?->detailOutpatientBill?->amount_cdf;
                } else if ($outpatientBill->currency->name == 'CDF') {
                    $total += $outpatientBill->getTotalOutpatientBillCDF();
                }
            }
        }
        return $total;
    }

    /**
     * getCountOfOutpatientBillByDate
     * @param mixed $date
     * @return int
     */
    public static function getCountOfOutpatientBillByDate(string $date): int
    {
        return  Auth::user()->roles->pluck('name')->contains(RoleType::MONEY_BOX) ||
            Auth::user()->roles->pluck('name')->contains(RoleType::EMERGENCY) ?
            OutpatientBill::whereDate('created_at', $date)
            ->where('is_validated', true)
            ->where('user_id', Auth::id())
            ->with(['otherOutpatientBill', 'currency', 'detailOutpatientBill', 'tarifs', 'consultation', 'rate', 'user'])
            ->count() :
            OutpatientBill::whereDate('created_at', $date)
            ->where('is_validated', true)
            ->with(['otherOutpatientBill', 'currency', 'detailOutpatientBill', 'tarifs', 'consultation', 'rate', 'user'])
            ->count();
    }

    /**
     * getCountOfOutpatientBillByMonth
     * @param mixed $month
     * @return int
     */
    public static function getCountOfOutpatientBillByMonth(string $month): int
    {
        return  Auth::user()->roles->pluck('name')->contains(RoleType::MONEY_BOX) ||
            Auth::user()->roles->pluck('name')->contains(RoleType::EMERGENCY) ?
            OutpatientBill::whereMonth('created_at', $month)
            ->where('is_validated', true)
            ->where('user_id', Auth::id())
            ->with(['otherOutpatientBill', 'currency', 'detailOutpatientBill', 'tarifs', 'consultation', 'rate', 'user'])
            ->count() :
            OutpatientBill::whereMonth('created_at', $month)
            ->where('is_validated', true)
            ->with(['otherOutpatientBill', 'currency', 'detailOutpatientBill', 'tarifs', 'consultation', 'rate', 'user'])
            ->count();
    }
}
