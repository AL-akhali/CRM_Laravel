<?php

namespace Database\Factories;

use App\Models\ClientTag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClientTagFactory extends Factory
{
    protected $model = ClientTag::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->word();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'color' => $this->faker->randomElement([
                '#f87171', '#34d399', '#60a5fa', '#facc15', // HEX
                'text-red-500', 'text-green-500', 'text-blue-500', 'text-yellow-500', // Tailwind
            ]),
        ];
    }
}
