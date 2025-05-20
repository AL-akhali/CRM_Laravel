<?php

namespace Database\Factories;

use App\Models\ClientActivity;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientActivityFactory extends Factory
{
    protected $model = ClientActivity::class;

    public function definition()
    {
        return [
            'client_id' => Client::factory(), // تنشئ عميل جديد تلقائياً
            'type' => $this->faker->randomElement(['call', 'email', 'meeting', 'note', 'update']),
            'description' => $this->faker->sentence(),
        ];
    }
}
