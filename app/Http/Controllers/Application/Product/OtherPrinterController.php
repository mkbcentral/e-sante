<?php

namespace App\Http\Controllers\Application\Product;

use App\Http\Controllers\Controller;
use App\Livewire\Helpers\Date\DateFormatHelper;
use App\Models\CategoryTarif;
use App\Models\Payroll;
use App\Models\Subscription;
use App\Models\Tarif;
use Illuminate\Support\Facades\App;

class OtherPrinterController extends Controller
{
    public function printListPriceTarif($type_data, $categoryTarifId = null)
    {
        if ($categoryTarifId != null) {
            $categoryTarif = CategoryTarif::find($categoryTarifId);
            $categoryTarifs = [];
        } else {
            $categoryTarif = null;
            $categoryTarifs = CategoryTarif::query()->orderBy('name', 'ASC')->get();
        }
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.tarifs.print-list-price',
            compact([
                'categoryTarif', 'categoryTarifs', 'type_data'
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }

    public function printProductFinanceRapportByMonth($month)
    {
        $subscriptions = Subscription::query()->where('is_private', false)
            ->where('is_activated', true)->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.finance.product.print-product-finance-rapport-by-month',
            compact([
                'month',
                'subscriptions'
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }

    public function printPayroll($id)
    {
        $payroll = Payroll::find($id);
        $payroll->is_valided=true;
        $payroll->update();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.finance.payroll.print-payroll',
            compact([
                'payroll'
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }

    //Print labo monthly release
    public function printLaboMonthlyReleases($month, $subscription_id)
    {
        $days
        = DateFormatHelper::getListDateForMonth($month,'2024');
        $tarifs= Tarif::query()->where('category_tarif_id', 1)
            ->orderBy('name', 'asc')
            ->get();
        $subscription=Subscription::find($subscription_id);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.labo.print-labo-monthly-release',
            compact([
                'month',
                'days','tarifs', 'subscription','subscription_id'
            ])
        )->set_option('isRemoteEnabled', true)->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

}
