<?php

namespace Database\Factories;

use App\Models\ShortLink;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShortLinkFactory extends Factory
{
    protected $model = ShortLink::class;

    public function definition(): array
    {
        return [
            'identifier' => $this->faker->unique()->firstName,
            'urlShort' => $this->faker->randomLetter(),
            'url' => $this->faker->url(),
            'hits' => $this->faker->numberBetween(50, 200)
        ];
    }
}
