<?php

namespace Database\Factories;

use App\Models\Response;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResponseFactory extends Factory
{
    protected $model = Response::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->word(),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
