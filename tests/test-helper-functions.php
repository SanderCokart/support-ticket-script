<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

function actingAsUser()
{
    Sanctum::actingAs($user = User::factory()->create());
    return $user;
}

function actingAsAdmin()
{
    Sanctum::actingAs($user = User::factory()->admin()->create());
    return $user;
}
