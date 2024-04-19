<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property int id
 * @property int type
 * @property string name
 * @property string description
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'name',
        'description',
    ];

    public function scopeCurrentUser(Builder $query): Builder
    {
        return $query->where('user_id', Auth::id());
    }
}
