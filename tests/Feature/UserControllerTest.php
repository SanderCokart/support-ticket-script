<?php

use App\Models\User;
use function Pest\Laravel\getJson;

test('admins can get a list of admins in alphabetical order', function () {
    actingAsAdmin();

    User::factory()->count(10)->admin()->create();

    $response = getJson(route('api.v1.auth.users.admins', absolute: false));
    $response->assertStatus(200);
    $response->assertJsonCount(User::admins()->count());
    $response->assertJsonStructure([
        '*' => [
            'id',
            'first_name',
            'last_name',
            'full_name',
        ],
    ]);

    actingAsUser();

    $response = getJson(route('api.v1.auth.users.admins', absolute: false));
    $response->assertStatus(403);

});
