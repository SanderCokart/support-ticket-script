<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResponseRequest;
use App\Models\Response;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketResponseController extends Controller
{
    public function index(Request $request, Ticket $ticket, Response $response): array
    {
        $this->authorize('viewAny', [$response, $ticket]);

        return Response::with('user:id,first_name,last_name,created_at')
            ->latest()
            ->whereBelongsTo($ticket)
            ->get()
            ->all();
    }

    public function store(ResponseRequest $request, Ticket $ticket, Response $response): JsonResponse
    {
        $this->authorize('create', [$response, $ticket]);

        $ticket->responses()->create($request->validated());

        return response()->json([
            'message' => 'Response successfully submitted',
        ], 201);
    }

    public function update(ResponseRequest $request, Ticket $ticket, Response $response): JsonResponse
    {
        $this->authorize('update', $response);

        $response->update($request->validated());

        return response()->json([
            'message' => 'Response successfully updated',
        ]);
    }
}
