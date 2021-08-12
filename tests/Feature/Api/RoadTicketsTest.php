<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Road;
use App\Models\Ticket;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoadTicketsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_road_tickets()
    {
        $road = Road::factory()->create();
        $ticket = Ticket::factory()->create();

        $road->allTracks()->attach($ticket);

        $response = $this->getJson(route('api.roads.tickets.index', $road));

        $response->assertOk()->assertSee($ticket->name);
    }

    /**
     * @test
     */
    public function it_can_attach_tickets_to_road()
    {
        $road = Road::factory()->create();
        $ticket = Ticket::factory()->create();

        $response = $this->postJson(
            route('api.roads.tickets.store', [$road, $ticket])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $road
                ->allTracks()
                ->where('tickets.id', $ticket->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_tickets_from_road()
    {
        $road = Road::factory()->create();
        $ticket = Ticket::factory()->create();

        $response = $this->deleteJson(
            route('api.roads.tickets.store', [$road, $ticket])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $road
                ->allTracks()
                ->where('tickets.id', $ticket->id)
                ->exists()
        );
    }
}
