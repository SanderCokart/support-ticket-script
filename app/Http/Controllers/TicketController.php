<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Response;

class TicketController extends Controller
{
    public function index()
    {
        return Ticket::all();
    }

    public function store(TicketRequest $request): Ticket
    {
        return Ticket::create($request->validated());
    }

    public function show(Ticket $ticket): Ticket
    {
        return $ticket;
    }

    public function update(TicketRequest $request, Ticket $ticket): Ticket
    {
        $ticket->update($request->validated());

        return $ticket;
    }

    public function destroy(Ticket $ticket): Response
    {
        $ticket->delete();

        return response()->noContent();
    }
}
