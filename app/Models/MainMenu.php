<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    * The users that belong to the MainMenu
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
   public function users(): BelongsToMany
   {
       return $this->belongsToMany(User::class, 'main_menu_user', 'user_id', 'main_menu_id');
   }
}
