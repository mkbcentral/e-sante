<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryTarif extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'hospital_id'];

    public function tarifs(): HasMany
    {
        return $this->hasMany(Tarif::class,);
    }
    public function getConsultationTarifItemls(ConsultationRequest $consultationRequest,CategoryTarif $categoryTarif):Collection
    {

        return DB::table('consultation_request_tarif')
            ->join('tarifs', 'tarifs.id', '=', 'consultation_request_tarif.tarif_id')
            ->join('category_tarifs', 'category_tarifs.id', '=', 'tarifs.category_tarif_id')
            ->select(
                'consultation_request_tarif.*',
                'tarifs.name',
                'tarifs.id as id_tarif',
                'category_tarifs.id as category_id')
            ->where('consultation_request_tarif.consultation_request_id',$consultationRequest->id)
            ->where('category_tarifs.id',$categoryTarif->id)
            ->where('category_tarifs.hospital_id',Hospital::DEFAULT_HOSPITAL)
            ->get();
    }
}
