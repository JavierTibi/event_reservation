<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_can_be_reserved_if_within_deadline_and_below_limit()
    {
        $event = Event::factory()->create([
            'reservation_deadline' => now()->addDay(),
            'attendee_limit' => 10,
        ]);

        $this->assertTrue($event->canBeReserved());
    }

    public function test_event_cannot_be_reserved_if_past_deadline()
    {
        $event = Event::factory()->create([
            'reservation_deadline' => now()->subDay(),
            'attendee_limit' => 10,
        ]);

        $this->assertFalse($event->canBeReserved());
    }
}
