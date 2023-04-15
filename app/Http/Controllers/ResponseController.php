<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResponseRequest;
use App\Models\Response;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ResponseController extends Controller
{

    public function store(ResponseRequest $request, Ticket $ticket): Response
    {
        return $ticket->responses()->create($request->validated());
    }

    public function update(ResponseRequest $request, Ticket $ticket, Response $response): Response
    {
        $response->update($request->validated());

        return $response;
    }

    public function destroy(Request $request, Ticket $ticket, Response $response): \Illuminate\Http\Response
    {
        $response->delete();

        return response()->noContent();
    }
}
