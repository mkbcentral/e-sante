<?php

namespace App\Repositories\Tarif;

use App\Models\Hospital;
use App\Models\Tarif;
use Illuminate\Support\Collection;

class GetListTarifRepository
{
    private static string $query;

    public static function getSimpleTarifByCategory(int $cateryId): Collection
    {
        return Tarif::join('category_tarifs', 'category_tarifs.id', '=', 'tarifs.category_tarif_id')
            ->where('category_tarifs.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('category_tarifs.source_id', auth()->user()->source->id)
            ->where('tarifs.category_tarif_id', $cateryId)
            ->select('tarifs.*')
            ->get();
    }

    public static function getListTarifByCategory(int $categoryid, string $q, string $sortBy, bool $sortAsc): Collection
    {
        SELF::$query = $q;
        return Tarif::join('category_tarifs', 'category_tarifs.id', 'tarifs.category_tarif_id')
            ->where('tarifs.category_tarif_id', $categoryid)
            ->when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('tarifs.name', 'like', '%' . SELF::$query . '%')
                        ->orWhere('tarifs.abbreviation', 'like', '%' . SELF::$query . '%')
                        ->orWhere('tarifs.price_private', 'like', '%' . SELF::$query . '%')
                        ->orWhere('tarifs.subscriber_price', 'like', '%' . SELF::$query . '%');
                });
            })->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->select('tarifs.*')
            ->where('tarifs.is_changed', false)
            ->where('category_tarifs.hospital_id', Hospital::DEFAULT_HOSPITAL())
            //->where('category_tarifs.source_id', auth()->user()->source->id)
            ->get();
    }

    public static function getListTarif(string $q, string $sortBy, bool $sortAsc, string $category, int $perPage = 5)
    {
        SELF::$query = $q;
        return Tarif::join('category_tarifs', 'category_tarifs.id', 'tarifs.category_tarif_id')
            ->when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('tarifs.name', 'like', '%' . SELF::$query . '%')
                        ->orWhere('tarifs.abbreviation', 'like', '%' . SELF::$query . '%')
                        ->orWhere('tarifs.price_private', 'like', '%' . SELF::$query . '%')
                        ->orWhere('tarifs.subscriber_price', 'like', '%' . SELF::$query . '%');
                });
            })->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->where('tarifs.is_changed', false)
            ->select('tarifs.*', 'category_tarifs.name as category')
            ->where('tarifs.category_tarif_id', 'like', '%' . $category . '%')
            ->where('category_tarifs.hospital_id', Hospital::DEFAULT_HOSPITAL())
            //->where('category_tarifs.source_id', auth()->user()->source->id)
            ->paginate($perPage);
    }
}
