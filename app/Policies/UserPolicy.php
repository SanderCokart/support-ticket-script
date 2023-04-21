<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\AdminBypassPolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization, AdminBypassPolicy;

    public function viewAnyAdmins(User $user): bool
    {
        return false;
    }
}
