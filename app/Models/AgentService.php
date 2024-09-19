<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AgentService extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'hospital_id'];

    /**
     * Get all of the consultationSheets for the AgentService
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consultationSheets(): HasMany
    {
        return $this->hasMany(ConsultationSheet::class);
    }

    /**
     * Get all of the productRequistions for the AgentService
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productRequistions(): HasMany
    {
        return $this->hasMany(ProductRequisition::class);
    }

    public function getAmountProduct(){
        $total=0;
        foreach ($this->productRequistions() as $productRequistion) {
            foreach ($productRequistion->productRequistionProducts as $productData) {
                $total +=$productData->product->price;
            }
        }

        return $total;
    }

}
