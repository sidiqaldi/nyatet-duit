<?php

namespace App\Enums;

enum TransactionType: int
{
    use ToArrayTrait;

    case Expense = 1;
    case Income = 2;
}
