<?php

use App\Enums\StatusEnum;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;

/** @see tests/Pest.php for Feature/Controllers seeder parameters */
test('users can see their tickets and admins can see all tickets', function () {
    $user = actingAsUser();
    Ticket::factory()->count(7)->create([
        'user_id' => $user->id,
    ]);

    Ticket::factory()->count(3)->create([
        'user_id' => User::factory()->create()->id,
    ]);

    $response = getJson(route('api.v1.auth.tickets.index', absolute: false));
    $response->assertStatus(200);

    $response->assertJsonCount(7, 'data');
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'title',
                'content',
                'status_id',
                'category_id',
                'user_id',
                'created_at',
                'updated_at',
            ],
        ],
    ]);

    actingAsAdmin();
    $response = getJson(route('api.v1.auth.tickets.index', absolute: false));
    $response->assertJsonCount(10, 'data');

});
test('users can access their own ticket and admins can access any ticket', function () {
    $user = actingAsUser();

    $ticket = Ticket::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->getJson(route('api.v1.auth.tickets.show', $ticket->id, absolute: false));
    $response->assertStatus(200);

    actingAsAdmin();

    $response = $this->getJson(route('api.v1.auth.tickets.show', $ticket->id, absolute: false));
    $response->assertStatus(200);

    $response->assertJsonStructure([
        'id',
        'title',
        'content',
        'status_id',
        'category_id',
        'user_id',
        'created_at',
        'updated_at',
    ]);

    actingAsUser();
    $response = $this->getJson(route('api.v1.auth.tickets.show', $ticket->id, absolute: false));
    $response->assertStatus(403);

});

test('anyone logged in can create a ticket', function () {
    $user = actingAsUser();

    $response = $this->postJson(route('api.v1.auth.tickets.store', absolute: false), [
        'title'       => 'Test Ticket',
        'content'     => 'Test Ticket Content',
        'status_id'   => StatusEnum::PENDING->getId(),
        'category_id' => Category::first()->id,
        'user_id'     => $user->id,
    ]);


    $response->assertStatus(201);
    $response->assertJsonStructure(['message']);

});

test('users can can update their ticket', function () {
    $user = actingAsUser();

    $ticket = Ticket::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = putJson(route('api.v1.auth.tickets.update', $ticket->id, absolute: false), [
        'title'       => 'Test Ticket',
        'content'     => 'Test Ticket Content',
        'category_id' => Category::first()->id,
        'user_id'     => $user->id,
    ]);

    $response->assertStatus(200);

    $response->assertJsonStructure(['message']);

});
