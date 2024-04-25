<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int category_id
 * @property int month
 * @property int year
 * @property int amount
 * @property ?Category category
 */
class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'month',
        'year',
        'amount',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'category_id', 'category_id');
    }
}
