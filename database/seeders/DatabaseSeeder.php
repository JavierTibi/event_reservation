<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        $events = Event::factory(20)->create([
            'user_id' => $users->random()->id,
        ]);

        //Reservas
        foreach ($events as $event) {
            $attendees = $users->random(rand(5, 10));
            foreach ($attendees as $user) {
                Reservation::factory()->create([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                ]);
    
                // Reviews
                if (rand(0, 1)) {
                    Review::factory()->create([
                        'user_id' => $user->id,
                        'event_id' => $event->id,
                    ]);
                }
            }
        }
    }
}
