<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'title'       => $this->faker->word(),
            'content'     => $this->faker->word(),
            'user_id'     => User::factory(),
            'status_id'   => StatusEnum::random()->getId(),
            'category_id' => Category::factory(),
            'created_at'  => $created_at = $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at'  => $this->faker->dateTimeBetween($created_at, 'now'),
        ];
    }
}
