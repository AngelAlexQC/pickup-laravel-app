<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
            'meta' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'datetime_start' => $this->faker->dateTime,
            'datetime_end' => $this->faker->dateTime,
            'vehicle_id' => \App\Models\Vehicle::factory(),
            'sender_id' => \App\Models\User::factory(),
            'reciever_id' => \App\Models\User::factory(),
            'driver_id' => \App\Models\User::factory(),
        ];
    }
}
