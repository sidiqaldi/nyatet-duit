<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TransactionPolicy
{
    public function update(User $user, Transaction $transaction): Response
    {
        if ($transaction->user_id === $user->id) {
            return Response::allow();
        }

        return Response::denyAsNotFound();
    }
}
