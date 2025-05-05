<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Support\Facades\Hash;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);
        $this->assertArrayHasKey('token', $response->json());
    }

    public function test_create_user_and_create_event()
    {
        $user = User::factory()->create([
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user, 'sanctum'); 

        $response = $this->postJson('/api/events', [
            'title' => 'Test Event',
            'description' => 'Desc',
            'date' => now()->addDays(5)->toDateTimeString(),
            'location' => 'Online',
            'price' => 10,
            'attendee_limit' => 5,
            'reservation_deadline' => now()->addDays(2)->toDateTimeString(),
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'event' => [
                'id',
                'title',
                'description',
                'date',
                'location',
                'price',
                'attendee_limit',
                'reservation_deadline',
                'user_id',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_user_can_reserve_and_review()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user, 'sanctum'); 

        $event = Event::factory()->create([
            'reservation_deadline' => now()->addDays(2),
            'attendee_limit' => 10,
        ]);

        $this->postJson("/api/events/{$event->id}/reserve", [])
             ->assertStatus(201);

        $this->postJson("/api/events/{$event->id}/review", [
            'rating' => 5,
            'comment' => 'Genial evento',
        ])->assertStatus(201);

        $this->getJson("/api/events/{$event->id}/reviews")
             ->assertStatus(200)
             ->assertJsonFragment(['rating' => 5]);
    }

    public function test_user_cannot_reserve_twice()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum'); 

        $event = Event::factory()->create([
            'attendee_limit' => 1,
            'reservation_deadline' => now()->addDay(),
        ]);

        Reservation::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        $this->postJson("/api/events/{$event->id}/reserve", [])
             ->assertStatus(422);
    }

    public function test_user_cannot_review_without_reservation()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum'); 

        $event = Event::factory()->create();

        $this->postJson("/api/events/{$event->id}/review", [
            'rating' => 4,
            'comment' => 'Comentario sin reserva'
        ])->assertStatus(422);
    }
}
