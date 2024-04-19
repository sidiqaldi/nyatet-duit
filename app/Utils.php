<?php

namespace App;

use Illuminate\Support\Carbon;
use Spatie\QueryBuilder\AllowedFilter;

class Utils
{
    public static function defaultTransactionFilter(): array
    {
        return [
            'type',
            'category_id',
            AllowedFilter::scope('search'),
        ];
    }

    public static function defaultDate(?Carbon $carbon = null)
    {
        if ($carbon == null) {
            return [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ];
        }

        return [
            $carbon->clone()->startOfMonth(),
            $carbon->clone()->endOfMonth(),
        ];
    }

    public static function handlePeriod($string = null)
    {
        if ($string != null) {
            return Carbon::createFromFormat('Y-m', $string);
        }

        return Carbon::now();
    }
}
