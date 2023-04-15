<?php

use App\Models\User;

test('user can register', function () {
    $response = $this->postJson(route('api.v1.guest.register', absolute: false),
        array_merge(User::factory()->make()->toArray(), [
            'password'              => 'password',
            'password_confirmation' => 'password',
        ])
    );

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'access_token',
        'user' => [
            'id',
            'first_name',
            'last_name',
            'email',
            'created_at',
            'updated_at',
        ],
    ]);

    $this->assertDatabaseHas('users', [
        'id'         => $response->json('user.id'),
        'first_name' => $response->json('user.first_name'),
        'last_name'  => $response->json('user.last_name'),
        'email'      => $response->json('user.email'),
    ]);
});

test('user can login', function () {
    $user = User::factory()->create();

    $response = $this->postJson(route('api.v1.guest.login', absolute: false), [
        'email'    => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'access_token',
        'user' => [
            'id',
            'first_name',
            'last_name',
            'email',
            'created_at',
            'updated_at',
        ],
    ]);

    $this->assertDatabaseHas('users', [
        'id'         => $response->json('user.id'),
        'first_name' => $response->json('user.first_name'),
        'last_name'  => $response->json('user.last_name'),
        'email'      => $response->json('user.email'),
    ]);
});

test('user can logout', function () {

    //check if user is logged in via request authorization header bearer token
    $user = User::factory()->create();
    $token = $user->createToken('test')->plainTextToken;

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson(route('api.v1.auth.logout', absolute: false));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('personal_access_tokens', [
        'tokenable_id' => auth()->id(),
    ]);

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson(route('api.v1.auth.logout', absolute: false));

    $response->assertStatus(401);

});

test('user can request his data', function (User $user) {
    $response = $this->getJson(route('api.v1.auth.user', absolute: false));

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'id',
        'first_name',
        'last_name',
        'telephonenumber',
        'email',
        'created_at',
        'updated_at',
    ]);

})->with('user');
