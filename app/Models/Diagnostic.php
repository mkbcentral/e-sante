<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Diagnostic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hospital_id',
        'category_diagnostic_id'
    ];
    /**
     * Get the hospital that owns the Diagnostic
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    /**
     * The consultationRequests that belong to the Diagnostic
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function consultationRequests(): BelongsToMany
    {
        return $this->belongsToMany(related: ConsultationRequest::class)->withPivot(['id']);
    }

    /**
     * Get the categoryDiagnostic that owns the Diagnostic
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoryDiagnostic(): BelongsTo
    {
        return $this->belongsTo(CategoryDiagnostic::class, 'category_diagnostic_id');
    }
}
