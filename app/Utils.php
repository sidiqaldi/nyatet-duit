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
            'date',
            AllowedFilter::scope('date_between'),
            AllowedFilter::scope('search'),
        ];
    }

    public static function defaultDate()
    {
        $startMonth = Carbon::now()->startOfMonth();

        $endMonth = Carbon::now()->endOfMonth();

        return [$startMonth->format('Y-m-d'), $endMonth->format('Y-m-d')];
    }
}
