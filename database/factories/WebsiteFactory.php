<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WebsiteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'url' => $this->faker->url,
        ];
    }
}
