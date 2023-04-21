<?php

namespace App\Traits;

use App\Models\User;

trait AdminBypassPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        return $user->is_admin ? true : null;
    }
}
