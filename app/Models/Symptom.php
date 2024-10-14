<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Symptom extends Model
{
    use HasFactory;

    protected $fillable=['name', 'category_diagnostic_id'];

    /**
     * Get the categoryDiagnostic that owns the Symptom
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoryDiagnostic(): BelongsTo
    {
        return $this->belongsTo(CategoryDiagnostic::class);
    }

    /**
     * The consultationRequests that belong to the Symptom
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function consultationRequests(): BelongsToMany
    {
        return $this->belongsToMany(ConsultationRequest::class)->withPivot('id', 'qty', 'dosage');;
    }
}
