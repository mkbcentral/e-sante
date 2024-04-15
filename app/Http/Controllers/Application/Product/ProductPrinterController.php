<?php

namespace App\Http\Controllers\Application\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\ProductRequisition;
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

    public function printProductListPrice(){
        $products=Product::query()->orderBy('name','ASC')->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.product.print-product-list-price',
            compact([
                'products',
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }

    public function printListProductRequisition($id)
    {
        $productRequisition=ProductRequisition::find($id);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.product.print-product-requisition',
            compact([
                'productRequisition',
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }

}
