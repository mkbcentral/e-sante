<?php

namespace App\Repositories\OutpatientBill;

use App\Models\OutpatientBill;

class ReportOutpatientRepository
{
    public static function getOuPatientBillSynthesisByMonth(
        string $month,
        string $year
    ) {
        $outpatientBills = OutpatientBill::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->with(['tarifs' => function ($query) {
                $query->with('categoryTarif');
            }, 'otherOutpatientBill', 'consultation'])
            ->where('is_validated', true)
            ->get();

        $totals = [];
        $other_amount = 0;
        $consultation_amount = 0;
        $actes_et_autres_amount = 0;

        foreach ($outpatientBills as $bill) {
            if ($bill->otherOutpatientBill) {
                $actes_et_autres_amount += $bill->otherOutpatientBill->amount;
            }
            $consultation_amount += $bill->consultation->price_private;
            foreach ($bill->tarifs as $tarif) {
                $category = $tarif->categoryTarif->name;
                $amount = $tarif->pivot->qty * $tarif->price_private;

                if ($category === 'AUTRES' || $category === 'NON TARIFIE' || $category === 'ACTES') {
                    $actes_et_autres_amount += $amount;
                } else {
                    if (!isset($totals[$category])) {
                        $totals[$category] = 0;
                    }
                    $totals[$category] += $amount;
                }
            }
        }
        $totals['ACTES ET AUTRES'] = $actes_et_autres_amount;
        $totals['CONSULTATION'] = $consultation_amount;
        return $totals;
    }

    public static function getOuPatientBillAmountByMonth(
        string $month,
        string $year
    ) {
        $outpatientBills = OutpatientBill::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->with(['tarifs', 'otherOutpatientBill', 'consultation'])
            ->where('is_validated', true)
            ->get();

        $totalAmount = 0;

        foreach ($outpatientBills as $bill) {
            if ($bill->otherOutpatientBill) {
                $totalAmount += $bill->otherOutpatientBill->amount;
            }
            $totalAmount += $bill->consultation->price_private;
            foreach ($bill->tarifs as $tarif) {
                $totalAmount += $tarif->pivot->qty * $tarif->price_private;
            }
        }

        return $totalAmount;
    }
    public static function getOuPatientBillCurrencyAmountByMonth(
        string $month,
        string $year
    ) {
        $outpatientBills = OutpatientBill::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->with([
                'tarifs',
                'otherOutpatientBill',
                'consultation',
                'currency',
                'detailOutpatientBill'
            ])
            ->where('is_validated', true)
            ->get();

        $totalAmountUSD = 0;
        $totalAmountCDF = 0;

        foreach ($outpatientBills as $bill) {
            if ($bill->currency && $bill->currency->name == 'USD') {
                foreach ($bill->tarifs as $tarif) {
                    $totalAmountUSD += $tarif->pivot->qty * $tarif->price_private;
                }
                if ($bill->otherOutpatientBill) {
                    $totalAmountUSD += $bill->otherOutpatientBill->amount;
                }
                $totalAmountUSD += $bill->consultation->price_private;
            } elseif ($bill->currency && $bill->currency->name == 'CDF') {
                foreach ($bill->tarifs as $tarif) {
                    $totalAmountCDF += $tarif->pivot->qty * $tarif->price_private * $bill->rate->rate;
                }
                if ($bill->otherOutpatientBill) {
                    $totalAmountCDF += $bill->otherOutpatientBill->amount * $bill->rate->rate;
                }
                $totalAmountCDF += $bill->consultation->price_private * $bill->rate->rate;
            } elseif (is_null($bill->currency)) {
                $totalAmountUSD += $bill->detailOutpatientBill->amount_usd ?? 0;
                $totalAmountCDF += $bill->detailOutpatientBill->amount_cdf ?? 0;
            }
        }

        return [
            'totalAmountUSD' => $totalAmountUSD,
            'totalAmountCDF' => $totalAmountCDF,
        ];
    }

    public static function getOuPatientBillListCurrencyAmountByMonth(
        string $month,
        string $year
    ) {
        $outpatientBills = OutpatientBill::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->with([
                'tarifs',
                'otherOutpatientBill',
                'consultation',
                'currency',
                'detailOutpatientBill'
            ])
            ->where('is_validated', true)
            ->get();

        $totalAmountUSD = 0;
        $totalAmountCDF = 0;

        foreach ($outpatientBills as $bill) {
            if ($bill->currency && $bill->currency->name == 'USD') {
                foreach ($bill->tarifs as $tarif) {
                    $totalAmountUSD += $tarif->pivot->qty * $tarif->price_private;
                }
                if ($bill->otherOutpatientBill) {
                    $totalAmountUSD += $bill->otherOutpatientBill->amount;
                }
                $totalAmountUSD += $bill->consultation->price_private;
            } elseif ($bill->currency && $bill->currency->name == 'CDF') {
                foreach ($bill->tarifs as $tarif) {
                    $totalAmountCDF += $tarif->pivot->qty * $tarif->price_private * $bill->rate->rate;
                }
                if ($bill->otherOutpatientBill) {
                    $totalAmountCDF += $bill->otherOutpatientBill->amount * $bill->rate->rate;
                }
                $totalAmountCDF += $bill->consultation->price_private * $bill->rate->rate;
            } elseif (is_null($bill->currency)) {
                $totalAmountUSD += $bill->detailOutpatientBill->amount_usd ?? 0;
                $totalAmountCDF += $bill->detailOutpatientBill->amount_cdf ?? 0;
            }
        }

        return [
            'totalAmountUSD' => $totalAmountUSD,
            'totalAmountCDF' => $totalAmountCDF,
        ];
    }
    public static function getOuPatientBillListWithCurrencyAmountByMonth(
        string $month,
        string $year
    ) {
        $outpatientBills = OutpatientBill::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->with([
                'tarifs',
                'otherOutpatientBill',
                'consultation',
                'currency',
                'detailOutpatientBill'
            ])
            ->where('is_validated', true)
            ->get();

        $billsWithAmounts = [];

        foreach ($outpatientBills as $bill) {
            $amountUSD = 0;
            $amountCDF = 0;

            if ($bill->currency && $bill->currency->name == 'USD') {
                foreach ($bill->tarifs as $tarif) {
                    $amountUSD += $tarif->pivot->qty * $tarif->price_private;
                }
                if ($bill->otherOutpatientBill) {
                    $amountUSD += $bill->otherOutpatientBill->amount;
                }
                $amountUSD += $bill->consultation->price_private;
            } elseif ($bill->currency && $bill->currency->name == 'CDF') {
                foreach ($bill->tarifs as $tarif) {
                    $amountCDF += $tarif->pivot->qty * $tarif->price_private * $bill->rate->rate;
                }
                if ($bill->otherOutpatientBill) {
                    $amountCDF += $bill->otherOutpatientBill->amount * $bill->rate->rate;
                }
                $amountCDF += $bill->consultation->price_private * $bill->rate->rate;
            } elseif (is_null($bill->currency)) {
                $amountUSD += $bill->detailOutpatientBill->amount_usd ?? 0;
                $amountCDF += $bill->detailOutpatientBill->amount_cdf ?? 0;
            }

            $date = $bill->created_at->format('d/m/Y');
            if (!isset($billsWithAmounts[$date])) {
                $billsWithAmounts[$date] = [];
            }

            $billsWithAmounts[$date][] = [
                'bill_number' => $bill->bill_number,
                'client_name' => $bill->client_name,
                'username' => $bill->user->name,
                'amount_usd' => $amountUSD,
                'amount_cdf' => $amountCDF,
            ];
        }

        return $billsWithAmounts;
    }
}
