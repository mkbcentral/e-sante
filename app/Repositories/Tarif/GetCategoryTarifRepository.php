<?php

namespace App\Repositories\Tarif;

use App\Models\CategoryTarif;
use App\Models\Hospital;
use Illuminate\Support\Collection;
class GetCategoryTarifRepository
{
    /**
     * Load list category tarif data from DB with hospital id
     * @return Collection
     */
    public static function getListCategories():Collection{
        return CategoryTarif::orderBy('name','ASC')
            ->where('hospital_id',Hospital::DEFAULT_HOSPITAL)
            ->get();
    }
}
