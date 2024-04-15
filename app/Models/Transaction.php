<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property int user_id
 * @property int type
 * @property int category_id
 * @property float amount
 * @property string description
 * @property Carbon date
 * @property ?Category category
 */
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'category_id',
        'amount',
        'description',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date:Y-m-d',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeDateBetween(Builder $query, $start, $end): Builder
    {
        return $query->whereBetween('date', [$start, $end]);
    }

    public function scopeSearch(Builder $query, $search): Builder
    {
        return $query->where('description', 'like', "%$search%");
    }
}
