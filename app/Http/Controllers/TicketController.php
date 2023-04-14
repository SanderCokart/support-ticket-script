<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        return Ticket::all();
    }

    public function store(Request $request): Ticket
    {
        $request->validate([
            'title'   => ['required', 'max:255'],
            'content' => ['required', 'max:4294967295'],
        ]);

        return Ticket::create($request->validated());
    }

    public function show(Ticket $ticket): Ticket
    {
        return $ticket;
    }

    public function update(Request $request, Ticket $ticket): Ticket
    {
        $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:4294967295'],
        ]);

        $ticket->update($request->validated());

        return $ticket;
    }

    public function destroy(Ticket $ticket): JsonResponse
    {
        $ticket->delete();

        return response()->json();
    }
}
