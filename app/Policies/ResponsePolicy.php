<?php

namespace App\Policies;

use App\Models\Response;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\AdminBypassPolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResponsePolicy
{
    use HandlesAuthorization, AdminBypassPolicy;

    public function viewAny(User $user, Response $response, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }

    public function create(User $user, Response $response, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }

    public function update(User $user, Response $response): bool
    {
        return $response->user_id === $user->id;
    }
}
