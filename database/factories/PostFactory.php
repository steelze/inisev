<?php

namespace Database\Factories;

use App\Models\Website;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph(rand(10, 20)),
            'website_id' => fn() => Website::inRandomOrder()->first()->id, 
        ];
    }
}
