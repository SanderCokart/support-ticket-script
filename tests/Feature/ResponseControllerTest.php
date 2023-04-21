<?php

use App\Models\Response;
use App\Models\Ticket;
use App\Models\User;

test('only ticket owners and admins can view responses to a ticket', function () {

    //<editor-fold desc="success">
    $user = actingAsUser();

    $ticket = Ticket::factory()->create([
        'user_id' => $user->id,
    ]);

    Response::factory()->create([
        'ticket_id' => $ticket->id,
        'user_id'   => $user->id,
    ]);

    $response = $this->getJson(
        route('api.v1.auth.tickets.responses.index', $ticket, absolute: false),
    );

    $response->assertStatus(200);

    actingAsAdmin();

    $response = $this->getJson(
        route('api.v1.auth.tickets.responses.index', $ticket, absolute: false),
    );

    $response->assertStatus(200);
    //</editor-fold>

    $response->assertJsonStructure([
        '*' => [
            'id',
            'ticket_id',
            'user_id',
            'content',
            'created_at',
            'updated_at',
        ],
    ]);

    //<editor-fold desc="failure">
    $newUser = actingAsUser();

    $ticket = Ticket::factory()->create([
        'user_id' => User::factory()->create()->id,
    ]);

    $response = $this->getJson(
        route('api.v1.auth.tickets.responses.index', $ticket, absolute: false),
    );

    $response->assertStatus(403);
    //</editor-fold>

});

test('only ticket owners and admins can leave a response to a ticket', function () {
    //<editor-fold desc="success">
    $user = actingAsUser();

    $ticket = Ticket::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->postJson(
        route('api.v1.auth.tickets.responses.store', $ticket, absolute: false),
        Response::factory()->make([
            'ticket_id' => $ticket->id,
            'user_id'   => $user->id,
        ])->toArray(),
    );
    $response->assertStatus(201);

    $admin = actingAsAdmin();

    $response = $this->postJson(
        route('api.v1.auth.tickets.responses.store', $ticket, absolute: false),
        $newResponse = Response::factory()->make([
            'ticket_id' => $ticket->id,
            'user_id'   => $admin->id,
        ])->toArray(),
    );

    $response->assertStatus(201);
    //</editor-fold>

    //<editor-fold desc="database">
    $response->assertJsonStructure(['message']);

    $this->assertDatabaseHas('responses', [
        'ticket_id' => $newResponse['ticket_id'],
        'user_id'   => $newResponse['user_id'],
        'content'   => $newResponse['content'],
    ]);
    //</editor-fold>

    //<editor-fold desc="failure">
    $newUser = actingAsUser();

    $response = $this->postJson(
        route('api.v1.auth.tickets.responses.store', $ticket, absolute: false),
        Response::factory()->make([
            'ticket_id' => $ticket->id,
            'user_id'   => $newUser->id,
        ])->toArray(),
    );

    $response->assertStatus(403);
    //</editor-fold>
});

test('only ticket owners and admins can update a response', function () {

    //<editor-fold desc="success">
    $user = actingAsUser();

    $responseModel = Response::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->putJson(
        route('api.v1.auth.tickets.responses.update', [
            'ticket'   => $responseModel->ticket_id,
            'response' => $responseModel->id,
        ], absolute: false),
        Response::factory()->make([
            'ticket_id' => $responseModel->ticket_id,
            'user_id'   => $user->id,
        ])->toArray(),
    );

    $response->assertStatus(200);

    $admin = actingAsAdmin();

    $response = $this->putJson(
        route('api.v1.auth.tickets.responses.update', [
            'ticket'   => $responseModel->ticket_id,
            'response' => $responseModel->id,
        ], absolute: false),
        $newResponse = Response::factory()->make([
            'ticket_id' => $responseModel->ticket_id,
            'user_id'   => $admin->id,
        ])->toArray(),
    );

    $response->assertStatus(200);
    //</editor-fold>

    //<editor-fold desc="database">
    $response->assertJsonStructure(['message']);

    $this->assertDatabaseHas('responses', [
        'ticket_id' => $newResponse['ticket_id'],
        'user_id'   => $newResponse['user_id'],
        'content'   => $newResponse['content'],
    ]);
    //</editor-fold>

    //<editor-fold desc="failure">
    $newUser = actingAsUser();

    $responseModel = Response::factory()->create([
        'user_id' => User::factory()->create()->id,
    ]);

    $response = $this->putJson(
        route('api.v1.auth.tickets.responses.update', [
            'ticket'   => $responseModel->ticket_id,
            'response' => $responseModel->id,
        ], absolute: false),
        Response::factory()->make([
            'ticket_id' => $responseModel->ticket_id,
            'user_id'   => $newUser->id,
        ])->toArray(),
    );

    $response->assertStatus(403);
    //</editor-fold>

});
