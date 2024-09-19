<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StockService extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];

    /**
     * Get the user that owns the StockService
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, foreignKey: 'user_id');
    }
    /**
     * The products that belong to the StockService
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(related: Product::class)->withPivot('id', 'qty', 'is_trashed');
    }
}
