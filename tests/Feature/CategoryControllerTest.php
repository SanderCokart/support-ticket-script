<?php

use App\Models\Category;
use App\Models\User;

/** @see tests/Pest.php for Feature/Controllers seeder parameters */
it('can get all categories', function () {
    actingAsAdmin();
    $response = $this->getJson(route('api.v1.auth.categories.index', absolute: false));
    $response->assertStatus(200);
    $response->assertJsonCount(Category::count());
    $response->assertJsonStructure([
        '*' => [
            'id',
            'title',
        ],
    ]);
});

it('can get a category', function () {
    actingAsAdmin();
    $category = Category::first();

    $response = $this->getJson(route('api.v1.auth.categories.show', $category->id, absolute: false));
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'id',
        'title',
    ]);
});

it('can create a category', function () {
    actingAsAdmin();
    $response = $this->postJson(route('api.v1.auth.categories.store', absolute: false), [
        'title' => 'Test Category',
    ]);
    $response->assertStatus(201);
    $response->assertJsonStructure([
        'id',
        'title',
    ]);
});

it('can update a category', function () {
    actingAsAdmin();
    $category = Category::first();

    $response = $this->putJson(route('api.v1.auth.categories.update', $category->id, absolute: false), [
        'title' => 'Test Category',
    ]);
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'id',
        'title',
    ]);
});

it('can delete a category', function () {
    actingAsAdmin();
    $category = Category::factory()->create();

    $response = $this->deleteJson(route('api.v1.auth.categories.destroy', $category->id, absolute: false));
    $response->assertStatus(204);
});

test('cannot delete a category with tickets', function () {
    $admin = actingAsAdmin();
    $category = Category::factory()->hasTickets(attributes: [
        'user_id' => $admin->id,
    ])->create();

    $response = $this->deleteJson(route('api.v1.auth.categories.destroy', $category->id, absolute: false));
    $response->assertStatus(422);
});
