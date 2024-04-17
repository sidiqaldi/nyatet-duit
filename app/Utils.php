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
            $startMonth = Carbon::now()->startOfMonth();

            $endMonth = Carbon::now()->endOfMonth();

            return [$startMonth->format('Y-m-d'), $endMonth->format('Y-m-d')];
        }

        $startMonth = $carbon->clone()->startOfMonth();

        $endMonth = $carbon->clone()->endOfMonth();

        return [$startMonth->format('Y-m-d'), $endMonth->format('Y-m-d')];
    }

    public static function handlePeriod($string = null)
    {
        if ($string != null) {
            return Carbon::createFromFormat('Y-m', $string);
        }

        return Carbon::now();
    }
}
