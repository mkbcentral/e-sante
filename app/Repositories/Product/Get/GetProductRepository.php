<?php

namespace App\Repositories\Product\Get;

use App\Models\Hospital;
use App\Models\Product;
use App\Models\ProductSupplyProduct;
use Illuminate\Support\Facades\Auth;

class GetProductRepository
{
    public static string $keyToSear, $categoryId, $familyId;
    public static function getProductList(
        string $q,
        string $sortBy,
        bool $sortAsc,
        string $categoryId,
        string $familyId,
        int $per_page = 25
    ) {
        SELF::$keyToSear = $q;
        return  Product::query()
            ->when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('products.name', 'like', '%' . SELF::$keyToSear . '%')
                        ->orWhere('products.price', 'like', '%' . SELF::$keyToSear . '%');
                });
            })->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->where('products.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('products.product_category_id', 'like', '%' . $categoryId . '%')
            ->where('products.product_family_id', 'like', '%' . $familyId . '%')
            ->where('products.is_trashed', false)
            ->whereIn('products.source_id', [1, 2])
            ->select('products.*')
            ->paginate($per_page);
    }

    public static function getProductListExceptFamilyAndCategory(
        string $q,
        string $sortBy,
        bool $sortAsc,
        int $per_page = 25
    ) {
        SELF::$keyToSear = $q;
        return  Product::when($q, function ($query) {
            return $query->where(function ($query) {
                return $query->where('products.name', 'like', '%' . SELF::$keyToSear . '%')
                    ->orWhere('products.price', 'like', '%' . SELF::$keyToSear . '%');
            });
        })->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->select('products.*')
            ->where('products.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('products.is_trashed', false)
            ->whereIn('products.source_id', [1, 2])
            ->paginate($per_page);
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
