<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientNoteFactory extends Factory
{
    protected $model = ClientNote::class;

    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'user_id' => User::factory(),
            'content' => $this->faker->sentence(),
            'visibility' => $this->faker->randomElement(['private', 'public']),
        ];
    }
}
