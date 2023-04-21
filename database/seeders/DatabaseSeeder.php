<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Response;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StatusSeeder::class,
            CategorySeeder::class,
        ]);

        User::factory()->create([
            'first_name'      => 'Test',
            'last_name'       => 'User',
            'telephonenumber' => '123456789',
            'email'           => 'test@example.com',
            'is_admin'        => true,
        ]);

        User::factory()
            ->count(100)
            ->has(Ticket::factory()
                ->count(3)
                ->has(
                    Response::factory()
                        ->count(3)
                        ->state(function (array $attributes, Ticket $ticket) {
                            return [
                                'user_id' => $ticket->user_id,
                            ];
                        })
                )
            )
            ->create();

    }
}
