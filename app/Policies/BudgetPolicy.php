<?php

namespace App\Policies;

use App\Models\Budget;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BudgetPolicy
{
    public function update(User $user, Budget $budget): Response
    {
        if ($budget->user_id === $user->id) {
            return Response::allow();
        }

        return Response::denyAsNotFound();
    }

    public function delete(User $user, Budget $budget): Response
    {
        if ($budget->user_id === $user->id) {
            return Response::allow();
        }

        return Response::denyAsNotFound();
    }
}
