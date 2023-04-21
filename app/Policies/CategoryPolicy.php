<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use App\Traits\AdminBypassPolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization, AdminBypassPolicy;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Category $category): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Category $category): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->is_admin;
    }
}
