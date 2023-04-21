<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use App\Traits\AdminBypassPolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization, AdminBypassPolicy;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function resolve(User $user, Ticket $ticket): bool
    {
        return false;
    }

    public function assign(User $user, Ticket $ticket): bool
    {
        return false;
    }
}
