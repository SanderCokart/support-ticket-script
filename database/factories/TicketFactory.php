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
        $problems = ['phone', 'laptop', 'tablet', 'account', 'internet connection', 'email'];
        $problem = collect($problems)->random();
        $content = 'So I have this ' . $problem . ' and it is not working. I have tried everything I can think of. I have tried to restart it, I have tried to turn it off and on again, I have tried to unplug it and plug it back in. I have tried to call the helpdesk but they are not answering.';
        return [
            'title'       => 'There is a problem with my ' . $problem,
            'content'     => $content,
            'user_id'     => User::factory(),
            'status_id'   => StatusEnum::random()->getId(),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'created_at'  => $this->faker->dateTimeBetween('-3 months', '-2 months')->format('U'),
            'updated_at'  => $this->faker->dateTimeBetween('-1 months', 'now')->format('U'),
            'assignee_id' => User::factory()->admin(),
        ];
    }
}
