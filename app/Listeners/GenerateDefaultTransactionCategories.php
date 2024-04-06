<?php

namespace App\Listeners;

use App\Enums\TransactionType;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateDefaultTransactionCategories implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        /** @var User */
        $user = $event->user;

        $user->categories()->createMany([
            [
                'name' => 'Groceries',
                'type' => TransactionType::Expense,
            ],
            [
                'name' => 'Utilities',
                'type' => TransactionType::Expense,
            ],
            [
                'name' => 'Rent',
                'type' => TransactionType::Expense,
            ],
            [
                'name' => 'Salary',
                'type' => TransactionType::Income,
            ],
            [
                'name' => 'Investment',
                'type' => TransactionType::Income,
            ],
            [
                'name' => 'Gifts',
                'type' => TransactionType::Income,
            ],
        ]);
    }
}
