<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResponseRequest;
use App\Models\Response;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketResponseController extends Controller
{
    public function index(Request $request, Ticket $ticket, Response $response)
    {

    }

    public function store(ResponseRequest $request, Ticket $ticket, Response $response)
    {

    }

    public function update(ResponseRequest $request, Ticket $ticket, Response $response)
    {

    }
}
