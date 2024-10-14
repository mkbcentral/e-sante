<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryDiagnostic extends Model
{
    use HasFactory;

    protected $fillable=['name'];

    /**
     * Get all of the diagnostics for the CategoryDiagnostic
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function diagnostics(): HasMany
    {
        return $this->hasMany(Diagnostic::class);
    }
}
