<?php

namespace App\Http\Controllers\Application\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductInvoice;
use Illuminate\Support\Facades\App;

class ProductInvoicePrinterController extends Controller
{
    public function printInvoiceProduct($id){
        $productInvoice=ProductInvoice::find($id);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.product.print-invoice-product',
            compact([
                'productInvoice',
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }
}
