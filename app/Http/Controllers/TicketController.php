<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\AssignTicketRequest;
use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TicketController extends Controller
{
    public function index(Request $request): LengthAwarePaginator
    {
        $this->authorize('viewAny', Ticket::class);

        $user = $request->user();

        return Ticket::query()
            ->with(['status', 'category', 'assignee:id,first_name,last_name'])
            ->orderBy('created_at', 'desc')
            ->when(! $user->is_admin, function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })
            ->paginate(20);
    }

    public function store(TicketRequest $request): JsonResponse
    {
        $this->authorize('create', Ticket::class);

        return response()->json([
            'message' => 'Ticket created',
        ], 201);
    }

    public function show(Request $request, Ticket $ticket): Ticket
    {
        $ticket->load('status', 'category', 'responses', 'assignee:id,first_name,last_name');

        if ($request->user()->is_admin) {
            $ticket->load('user');
        }

        $this->authorize('view', $ticket);

        return $ticket;
    }

    public function update(TicketRequest $request, Ticket $ticket): JsonResponse
    {
        $this->authorize('update', $ticket);

        $ticket->update($request->validated());

        return response()->json([
            'message' => 'Ticket updated',
        ]);
    }

    public function assign(AssignTicketRequest $request, Ticket $ticket): JsonResponse
    {
        $this->authorize('assign', $ticket);

        $ticket->assignee()->associate($request->safe()->assignee_id);
        $ticket->status()->associate(StatusEnum::IN_PROGRESS->getId());

        $ticket->save();

        return response()->json([
            'message' => 'Ticket assigned',
        ]);
    }

    public function resolve(Request $request, Ticket $ticket): JsonResponse
    {
        $this->authorize('resolve', $ticket);

        $ticket->status()->associate(StatusEnum::RESOLVED->getId());

        $ticket->save();

        return response()->json([
            'message' => 'Ticket resolved',
        ]);
    }

}
