<?php

namespace App\Listeners;

use App\Events\CategoryUpdated;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class UpdateTransactionsOnCategoryChanged
{
    public function __construct()
    {
    }

    public function handle(CategoryUpdated $event): void
    {
        if ($event->category->type != $event->oldType) {
            Transaction::where('category_id', $event->category->id)
                ->update([
                    'amount' => DB::raw('-amount'),
                    'type' => $event->category->type,
                ]);
        }
    }
}
