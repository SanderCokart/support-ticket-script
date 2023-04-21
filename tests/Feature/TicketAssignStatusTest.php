<?php

//test that admins can assign tickets to admins, which updates the status to IN_PROGRESS,
//after which the ticket can be marked as resolved by any admin

use App\Enums\StatusEnum;
use App\Models\{Ticket, User};
use function Pest\Laravel\putJson;

test('admins can assign tickets to admins', function () {
    actingAsAdmin();
    $admin = User::factory()->admin()->create();

    $ticket = Ticket::factory()->create([
        'assignee_id' => User::factory()->create()->id,
    ]);

    $response = putJson(
        route('api.v1.auth.tickets.assign', $ticket, absolute: false),
        ['assignee_id' => $admin->id,],
    );

    $response->assertStatus(200);

    $response->assertJsonStructure(['message']);

    actingAsUser();

    $response = putJson(
        route('api.v1.auth.tickets.assign', $ticket, absolute: false),
        ['assignee_id' => $admin->id,],
    );

    $response->assertStatus(403);

    $response->assertJsonStructure(['message']);
});


test('admins can mark tickets as resolved', function () {
    actingAsAdmin();
    $admin = User::factory()->admin()->create();

    $ticket = Ticket::factory()->create([
        'assignee_id' => $admin->id,
        'status_id'      => StatusEnum::IN_PROGRESS->getId(),
    ]);

    $response = putJson(
        route('api.v1.auth.tickets.resolve', $ticket, absolute: false),
    );

    $response->assertStatus(200);

    $response->assertJsonStructure(['message']);

    actingAsUser();

    $response = putJson(
        route('api.v1.auth.tickets.resolve', $ticket, absolute: false),
    );

    $response->assertStatus(403);

    $response->assertJsonStructure(['message']);
});
