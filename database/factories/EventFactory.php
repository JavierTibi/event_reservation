<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'date' => now()->addDays(rand(5, 30)),
            'location' => $this->faker->city,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'attendee_limit' => rand(10, 100),
            'reservation_deadline' => now()->addDays(rand(2, 4)),
        ];
    }
}
