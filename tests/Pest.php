<?php

use Database\Seeders\CategorySeeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\TicketSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function Pest\Laravel\seed;

include __DIR__ . '/test-helper-functions.php';

//Global
//uses(TestCase::class, RefreshDatabase::class)->in('Feature');

//Specific
uses(TestCase::class, RefreshDatabase::class)->beforeEach(function () {
    seed([
        CategorySeeder::class,
        StatusSeeder::class,
        TicketSeeder::class,
    ]);
})->in('Feature/Controllers');


