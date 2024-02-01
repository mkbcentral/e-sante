<?php

namespace App\Repositories\Product\Get;

use App\Models\Hospital;
use App\Models\Product;
use App\Models\ProductSupplyProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class GetProductRepository
{
    public static string $keyToSear;
    public static function getProductList(
        string $q,
        string $sortBy,
        bool $sortAsc,
        string $categoryId,
        string $familyId,
        int $per_page = 25
    ) {
        SELF::$keyToSear = $q;
        return  Product::when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('name', 'like', '%' . SELF::$keyToSear . '%')
                        ->orWhere('price', 'like', '%' . SELF::$keyToSear . '%');
                });
            })->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            //->where('products.product_category_id', 'like', '%' . $categoryId . '%')
            //->where('products.product_family_id', 'like', '%' . $familyId . '%')
            ->where( 'products.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('products.source_id', auth()->user()->source->id)
            ->paginate($per_page);
    }

    public static function getProductListExceptFamilyAndCategory(
        string $q,
        string $sortBy,
        bool $sortAsc,
        int $per_page = 25
    ) {
        SELF::$keyToSear = $q;
        return  Product::join('product_families', 'product_families.id', 'products.product_family_id')
            ->join('product_categories', 'product_categories.id', 'products.product_category_id')
            ->when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('products.name', 'like', '%' . SELF::$keyToSear . '%')
                        ->orWhere('products.price', 'like', '%' . SELF::$keyToSear . '%');
                });
            })->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->select('products.*', 'product_families.name as family', 'product_categories.abbreviation')
            ->where('products.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('products.source_id', auth()->user()->source->id)
            ->paginate($per_page);
    }

    public static function getListProductByService():Collection{
        return ProductSupplyProduct::join('products', 'products.id', 'product_supply_products.product_id')
            ->join('product_supplies', 'product_supplies.id', 'product_supply_products.product_supply_id')
            ->join('users', 'users.id', 'product_supplies.user_id')
            ->select('product_supply_products.*', 'products.name as product_name')
            ->with(['product'])
            ->where('users.agent_service_id', Auth::user()->agentService->id)
            ->get();
    }
}
