<?php

namespace Database\Factories;

use App\Models\Road;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Road::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'meta' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'address_start_id' => \App\Models\Address::factory(),
            'address_end_id' => \App\Models\Address::factory(),
        ];
    }
}
