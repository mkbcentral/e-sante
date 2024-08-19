<?php

namespace App\Repositories\Product\Get;

use App\Models\Hospital;
use App\Models\Product;
use App\Models\ProductInvoice;
use App\Models\ProductSupplyProduct;
use Illuminate\Support\Facades\Auth;

class GetProductRepository
{
    public static string $keyToSear;
    public static function getList(
        ?string $q,
        ?string $sortBy,
        ?bool $sortAsc,
        ?string $categoryId,
        ?string $familyId,
        ?int $per_page = 25,
        ?bool $is_trashed
    ) {
        SELF::$keyToSear = $q;
        return Product::query()
            ->when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('products.name', 'like', '%' . SELF::$keyToSear . '%')
                        ->orWhere('products.price', 'like', '%' . SELF::$keyToSear . '%');
                });
            })
            ->when(
                $categoryId,
                function ($query, $val) {
                    return $query->where('products.product_category_id', $val);
                }
            )
            ->when(
                $familyId,
                function ($query, $val) {
                    return $query->where('products.product_family_id', $val);
                }
            )
            ->whereIn('products.source_id', [1, 2])
            ->where('products.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('products.is_trashed', $is_trashed)
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->select('products.*')
            ->with([
                'productCategory',
            ])
            ->paginate($per_page);
    }

    public static function getNumberProductOutputOnProductInvoice(
        int $productId,
        ?string $date,
        ?string $startDate,
        ?string $endDate
    ): int|float {
        return ProductInvoice::query()
            ->join('product_product_invoice', 'product_product_invoice.product_invoice_id', 'product_invoices.id')
            ->join('users', 'users.id', 'product_invoices.user_id')
            ->where('product_product_invoice.product_id', $productId)
            ->where('product_invoices.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('product_invoices.user_id', Auth::id())
            ->where('users.source_id', Auth::user()->source->id)
            ->where('product_invoices.is_valided', true)
            ->when($date, function ($query, $val) {
                return $query->whereDate('product_invoices.created_at', $val);
            })
            ->when(
                $startDate && $endDate,
                function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('product_invoices.created_at', [$startDate, $endDate]);
            })
            ->sum('product_product_invoice.qty');
    }


    public static function getListProductByService()
    {
        return ProductSupplyProduct::join('products', 'products.id', 'product_supply_products.product_id')
            ->join('product_supplies', 'product_supplies.id', 'product_supply_products.product_supply_id')
            ->join('users', 'users.id', 'product_supplies.user_id')
            ->select('product_supply_products.*', 'products.name as product_name')
            ->with(['product'])
            ->where('users.agent_service_id', Auth::user()->agentService->id)
            ->paginate(50);
    }
}
