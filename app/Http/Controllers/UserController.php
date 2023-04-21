<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    public function admins(): Collection
    {
        $this->authorize('viewAnyAdmins', User::class);

        return User::whereIsAdmin(true)
            ->orderBy('first_name')
            ->get();
    }
}
