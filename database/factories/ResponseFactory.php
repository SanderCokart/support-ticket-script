<?php

namespace Database\Factories;

use App\Models\Response;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResponseFactory extends Factory
{
    protected $model = Response::class;

    public function definition(): array
    {
        return [
            'content'   => $this->faker->paragraph,
            'user_id'   => User::factory(),
            'ticket_id' => Ticket::factory(),
            'created_at' => $created_at = $this->faker->dateTimeBetween('-3 months', '-2 months'),
            'updated_at' => $created_at,
        ];
    }
}
