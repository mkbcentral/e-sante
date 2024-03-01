<?php

namespace App\Http\Controllers\Application\Product;

use App\Http\Controllers\Controller;
use App\Models\CategoryTarif;
use Illuminate\Support\Facades\App;

class OtherPrinterController extends Controller
{
    public function printListPriceTarif($type_data,$categoryTarifId=null)
    {
        if ($categoryTarifId!=null) {
            $categoryTarif = CategoryTarif::find($categoryTarifId);
            $categoryTarifs=[];
        }else{
            $categoryTarif=null;
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
}
