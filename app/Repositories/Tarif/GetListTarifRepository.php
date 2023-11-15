<?php

namespace App\Repositories\Tarif;

use App\Models\Tarif;

class GetListTarifRepository
{
    public static function getListTarif(string $q,string $sortBy,bool  $sortAsc,string $category,int $perPage=5){
        return Tarif::join('category_tarifs','category_tarifs.id','tarifs.category_tarif_id')
            ->when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('tarifs.name', 'like', '%' . $this->q . '%')
                        ->orWhere('tarifs.price_private', 'like', '%' . $this->q . '%')
                        ->orWhere('tarifs.subscriber_price', 'like', '%' . $this->q . '%');
                });
            })->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->where('tarifs.is_changed',false)
            ->select('tarifs.*','category_tarifs.name as category')
            ->where('tarifs.category_tarif_id','like','%'.$category.'%')
            ->where('category_tarifs.hospital_id',1)
            ->paginate($perPage);
    }

}
