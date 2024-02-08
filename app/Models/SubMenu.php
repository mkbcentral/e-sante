<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubMenu extends Model
{

    protected $fillable = ['name', 'icon', 'link','hospital_id'];
    use HasFactory;

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
     * Get all of the subMenuUsers for the SubMenu
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subMenuUsers(): HasMany
    {
        return $this->hasMany(SubMenuUser::class);
    }

}
