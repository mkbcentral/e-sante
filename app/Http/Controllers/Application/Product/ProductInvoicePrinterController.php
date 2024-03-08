<?php

namespace App\Http\Controllers\Application\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductInvoice;
use App\Repositories\Product\Get\GetProductInvoiceRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class ProductInvoicePrinterController extends Controller
{
    public function printInvoiceProduct($id)
    {
        $productInvoice = ProductInvoice::find($id);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.product.print-invoice-product',
            compact([
                'productInvoice',
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }
    public function printOutpatientBillRapportByDate($date)
    {
        $listInvoices = GetProductInvoiceRepository::getInvoiceByDate($date);
        $totalInvoice = GetProductInvoiceRepository::getTotalInvoiceByDate($date);
        $dateToMorrow = Carbon::tomorrow();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.product.print-product-invoice-rapport-by-date',
            compact([
                'listInvoices', 'totalInvoice', 'dateToMorrow'
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }

    public function printOutpatientBillRapportByMonth($month)
    {
        $listInvoices = GetProductInvoiceRepository::getInvoiceByMonth($month);
        $totalInvoice = GetProductInvoiceRepository::getTotalInvoiceByMonth($month);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'prints.product.print-product-invoice-rapport-by-date',
            compact([
                'listInvoices', 'totalInvoice'
            ])
        )->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }
}
