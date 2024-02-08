<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MainMenu extends Model
{
    use HasFactory;

    protected $fillable=['name','icon','link','bg','hospital_id'];

    /**
     * Get the hospital that owns the MainMenu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    /**
     * Get all of the mainMenuUsers for the MainMenu
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mainMenuUsers(): HasMany
    {
        return $this->hasMany(MainMenuUser::class);
    }
}
