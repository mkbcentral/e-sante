<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
