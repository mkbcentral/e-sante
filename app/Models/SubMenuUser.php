<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubMenuUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'sub_menu_id'];

    /**
     * Get the subMenu that owns the SubMenuUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subMenu(): BelongsTo
    {
        return $this->belongsTo(SubMenu::class, 'sub_menu_user_id');
    }

    /**
     * Get the user that owns the SubMenuUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
