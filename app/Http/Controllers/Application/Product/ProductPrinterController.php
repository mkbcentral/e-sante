<?php

namespace App\Http\Controllers\Application\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductPurchase;
use Illuminate\Support\Facades\App;

class ProductPrinterController extends Controller
{
    public function printProductPurcharseList(ProductPurchase $productPurchase){
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.product.print-product-purcharse',
            compact([
                'productPurchase',
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }
}
