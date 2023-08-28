<?php

namespace Database\Factories;

use App\Models\LogAccess;
use App\Models\ShortLink;
use Illuminate\Database\Eloquent\Factories\Factory;

use function Psy\debug;

class LogAccessFactory extends Factory
{
    protected $model = LogAccess::class;

    public function definition(): array
    {
        $sortLink = ShortLink::all()->random();
        return [
            'ip' => $this->faker->ipv4(),
            'date' => $this->faker->dateTime(),
            'country' => $this->faker->country(),
            'continent' => $this->faker->country(),
            'region' => $this->faker->state,
            'city' => $this->faker->city(),
            'userAgent' => $this->faker->userAgent(),
            'identifierUrl' => $sortLink->identifier,
            'short_link_id' => $sortLink->id
        ];
    }
}
