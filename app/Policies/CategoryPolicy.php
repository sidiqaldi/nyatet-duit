<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    public function update(User $user, Category $category): Response
    {
        if ($category->user_id === $user->id) {
            return Response::allow();
        }

        return Response::denyAsNotFound();
    }

    public function delete(User $user, Category $category): Response
    {
        if ($category->user_id === $user->id) {
            return Response::allow();
        }

        return Response::denyAsNotFound();
    }
}
