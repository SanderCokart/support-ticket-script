<?php

use App\Models\Category;
use App\Models\User;

/** @see tests/Pest.php for Feature/Controllers seeder parameters */
it('can get all categories', function (User $admin) {
    $response = $this->getJson(route('api.v1.auth.categories.index', absolute: false));
    $response->assertStatus(200);
    $response->assertJsonCount(3);
    $response->assertJsonStructure([
        '*' => [
            'id',
            'title',
        ],
    ]);
})->with('admin');

it('can get a category', function (User $admin) {
    $category = Category::first();

    $response = $this->getJson(route('api.v1.auth.categories.show', $category->id, absolute: false));
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'id',
        'title',
    ]);
})->with('admin');

it('can create a category', function (User $admin) {
    $response = $this->postJson(route('api.v1.auth.categories.store', absolute: false), [
        'title' => 'Test Category',
    ]);
    $response->assertStatus(201);
    $response->assertJsonStructure([
        'id',
        'title',
    ]);
})->with('admin');

it('can update a category', function (User $admin) {
    $category = Category::first();

    $response = $this->putJson(route('api.v1.auth.categories.update', $category->id, absolute: false), [
        'title' => 'Test Category',
    ]);
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'id',
        'title',
    ]);
})->with('admin');

it('can delete a category', function (User $admin) {
    $category = Category::factory()->create();

    $response = $this->deleteJson(route('api.v1.auth.categories.destroy', $category->id, absolute: false));
    $response->assertStatus(204);
})->with('admin');

test('cannot delete a category with tickets', function (User $admin) {
    $category = Category::factory()->hasTickets(attributes: [
        'user_id' => $admin->id,
    ])->create();

    $response = $this->deleteJson(route('api.v1.auth.categories.destroy', $category->id, absolute: false));
    $response->assertStatus(422);
})->with('admin');
