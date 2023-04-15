<?php

use App\Enums\StatusEnum;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;

/** @see tests/Pest.php for Feature/Controllers seeder parameters */
it('can get all tickets', function (User $admin) {
    $response = $this->getJson(route('api.v1.auth.tickets.index', absolute: false));
    $response->assertJsonCount(Ticket::count());
    $response->assertStatus(200);
    $response->assertJsonStructure([
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
    ]);

})->with('admin');

it('can get a ticket', function (User $admin) {
    $ticket = Ticket::first();

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

})->with('admin');

it('can create a ticket', function (User $admin) {
    $response = $this->postJson(route('api.v1.auth.tickets.store', absolute: false), [
        'title'       => 'Test Ticket',
        'content'     => 'Test Ticket Content',
        'status_id'   => StatusEnum::RESOLVED->getId(),
        'category_id' => Category::first()->id,
        'user_id'     => $admin->id,
    ]);

    $response->assertStatus(201);
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

})->with('admin');

it('can update a ticket', function (User $admin) {
    $ticket = Ticket::first();

    $response = $this->putJson(route('api.v1.auth.tickets.update', $ticket->id, absolute: false), [
        'title'       => 'Test Ticket',
        'content'     => 'Test Ticket Content',
        'status_id'   => StatusEnum::RESOLVED->getId(),
        'category_id' => Category::first()->id,
        'user_id'     => $admin->id,
    ]);
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

})->with('admin');
