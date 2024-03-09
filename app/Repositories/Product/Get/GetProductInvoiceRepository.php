<?php

namespace App\Repositories\Product\Get;

use App\Models\ProductInvoice;
use Illuminate\Support\Collection;

class GetProductInvoiceRepository
{

    public static function getInvoiceByDate(string $date, $is_valided = false): Collection
    {
        return $is_valided == false ? ProductInvoice::orderBy('created_at', 'DESC')
            ->whereDate('created_at', $date)
            ->get() :
            ProductInvoice::orderBy('created_at', 'DESC')
            ->whereDate('created_at', $date)
            ->where('is_valided', $is_valided)
            ->get();
    }

    public static function getInvoiceByMonth(string $month): Collection
    {
        return ProductInvoice::orderBy('created_at', 'DESC')
            ->whereMonth('created_at', $month)
            ->where('is_valided', true)
            ->get();
    }

    public static function getTotalInvoiceByDate(string $date): int|float
    {
        $invoices = ProductInvoice::orderBy('created_at', 'DESC')
            ->whereDate('created_at', $date)
            ->where('is_valided', true)
            ->get();
        $total = 0;
        foreach ($invoices as $invoice) {
            foreach ($invoice->products as $product) {
                $total += $product->price * $product->pivot->qty;
            }
        }
        return $total;
    }

    public static function getTotalInvoiceByMonth(string $month): int|float
    {
        $invoices = ProductInvoice::orderBy('created_at', 'DESC')
            ->whereMonth('created_at', $month)
            ->where('is_valided', true)
            ->get();
        $total = 0;
        foreach ($invoices as $invoice) {
            foreach ($invoice->products as $product) {
                $total += $product->price * $product->pivot->qty;
            }
        }
        return $total;
    }
}
