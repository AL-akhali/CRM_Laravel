<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'type' => 'شركة', // أو 'شركه' حسب enum إن وجدت
            'email' => $this->faker->unique()->safeEmail,
            'status' => 'فعال',
        ];
    }
}

