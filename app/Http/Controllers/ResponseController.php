<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function index()
    {
        return Response::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required', 'max:65535'],
        ]);

        return Response::create($request->validated());
    }

    public function show(Response $response)
    {
        return $response;
    }

    public function update(Request $request, Response $response)
    {
        $request->validate([
            'content' => ['required'],
        ]);

        $response->update($request->validated());

        return $response;
    }

    public function destroy(Response $response)
    {
        $response->delete();

        return response()->json();
    }
}
