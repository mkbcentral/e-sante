<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Hospital extends Model
{
    use HasFactory;
    protected $fillable=['name','email','phone','logo'];
    /**
     * Get all of the consultationSheets for the Subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consultationSheets(): HasMany
    {
        return $this->hasMany(ConsultationSheet::class);
    }
    /**
     * Get all of the users for the Hospital
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the source associated with the Hospital
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function source(): HasOne
    {
        return $this->hasOne(Source::class);
    }

    public static function DEFAULT_HOSPITAL():int{
        return auth()->user()->hospital->id;
    }
}
