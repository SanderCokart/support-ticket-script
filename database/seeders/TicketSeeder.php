<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Status;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::factory()->createMany([
            ['title' => 'Test Category 1'],
            ['title' => 'Test Category 2'],
            ['title' => 'Test Category 3'],
        ]);

        Ticket::factory()
            ->hasResponses(3)
            ->createMany([
            [
                'title'       => 'Test Ticket 1',
                'content'     => 'This is the first test ticket',
                'status_id'   => Status::PENDING['id'],
                'user_id'     => 1,
                'category_id' => $categories[0]->id,
            ],
            [
                'title'       => 'Test Ticket 2',
                'content'     => 'This is the second test ticket',
                'status_id'   => Status::IN_PROGRESS['id'],
                'user_id'     => 1,
                'category_id' => $categories[1]->id,
            ],
            [
                'title'       => 'Test Ticket 3',
                'content'     => 'This is the third test ticket',
                'status_id'   => Status::RESOLVED['id'],
                'user_id'     => 1,
                'category_id' => $categories[2]->id,
            ],
        ]);
    }
}
