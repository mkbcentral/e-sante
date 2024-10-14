<?php

namespace App\Http\Controllers\Application\Product;

use App\Models\Tarif;
use App\Models\Consultation;
use App\Models\Subscription;
use App\Models\CategoryTarif;
use App\Models\Hospitalization;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Livewire\Helpers\Date\DateFormatHelper;

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
        $consultations=Consultation::whereIn('id',[1,4,5])->get();
        $hospitalizations = Hospitalization::whereIn('id', [1, 2, 3,4,7,8])->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.tarifs.print-list-price',
            compact([
                'categoryTarif', 'categoryTarifs', 'type_data',
                'consultations',
                'hospitalizations'
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
