<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        Status::factory()->createMany([
            Status::PENDING,
            Status::IN_PROGRESS,
            Status::RESOLVED,
        ]);
    }
}
