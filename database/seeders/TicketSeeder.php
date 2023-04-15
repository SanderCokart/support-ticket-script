<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(?int $amount = 3): void
    {
        if (! Category::exists()) {
            $this->call(CategorySeeder::class);
        }

        $categories = Category::all();

        User::factory()
            ->has(Ticket::factory()
                ->count(3)
                ->hasResponses(3)
                ->sequence(
                    fn() => [
                        'status_id'   => StatusEnum::PENDING->getId(),
                        'category_id' => $categories[0],
                    ],
                    fn() => [
                        'status_id'   => StatusEnum::IN_PROGRESS->getId(),
                        'category_id' => $categories[1],
                    ],
                    fn() => [
                        'status_id'   => StatusEnum::RESOLVED->getId(),
                        'category_id' => $categories[2],
                    ],
                )
            )->create();
    }
}
