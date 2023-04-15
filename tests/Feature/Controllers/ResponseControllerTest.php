<?php

use App\Models\Response;
use App\Models\Ticket;
use App\Models\User;

test('user can leave a response to a ticket', function (User $user) {
    $ticket = Ticket::first();
    $response = $this->postJson(
        route('api.v1.auth.tickets.responses.store', $ticket, absolute: false),
        Response::factory()->make([
            'ticket_id' => $ticket->id,
            'user_id'   => $user->id,
        ])->toArray(),
    );

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'id',
        'ticket_id',
        'user_id',
        'content',
        'created_at',
        'updated_at',
    ]);

    $this->assertDatabaseHas('responses', [
        'id'        => $response->json('id'),
        'ticket_id' => $response->json('ticket_id'),
        'user_id'   => $response->json('user_id'),
        'content'   => $response->json('content'),
    ]);

})->with('user');

test('user can only update his/her response', function (User $user) {
    $responseModel = Response::factory()->create([
        'user_id' => $user->id,
    ]);

    $responseModel->content = 'Updated content';

    $response = $this->putJson(
        route('api.v1.auth.tickets.responses.update', [
            'ticket'   => $responseModel->ticket_id,
            'response' => $responseModel->id,
        ], absolute: false),
        $responseModel->toArray(),
    );

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'id',
        'ticket_id',
        'user_id',
        'content',
        'created_at',
        'updated_at',
    ]);

    $this->assertDatabaseHas('responses', [
        'id'        => $response->json('id'),
        'ticket_id' => $response->json('ticket_id'),
        'user_id'   => $response->json('user_id'),
        'content'   => $response->json('content'),
    ]);

    $responseModel = Response::factory()->create([
        'user_id' => User::factory()->create()->id,
    ]);

    $responseModel->content = 'Updated content';

    $response = $this->putJson(
        route('api.v1.auth.tickets.responses.update', [
            'ticket'   => $responseModel->ticket_id,
            'response' => $responseModel->id,
        ], absolute: false),
        $responseModel->toArray(),
    );

    $response->assertStatus(403);

})->with('user');

test('user can only delete his/her response', function (User $user) {
    $responseModel = Response::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->deleteJson(
        route('api.v1.auth.tickets.responses.destroy', [
            'ticket'   => $responseModel->ticket_id,
            'response' => $responseModel->id,
        ], absolute: false),
    );

    $response->assertStatus(204);

    $this->assertDatabaseMissing('responses', [
        'id' => $responseModel->id,
    ]);

    $responseModel = Response::factory()->create([
        'user_id' => User::factory()->create()->id,
    ]);

    $response = $this->deleteJson(
        route('api.v1.auth.tickets.responses.destroy', [
            'ticket'   => $responseModel->ticket_id,
            'response' => $responseModel->id,
        ], absolute: false),
    );

    $response->assertStatus(403);

})->with('user');
