<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Road;
use App\Models\Ticket;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketRoadsTest extends TestCase
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
    public function it_gets_ticket_roads()
    {
        $ticket = Ticket::factory()->create();
        $road = Road::factory()->create();

        $ticket->roads()->attach($road);

        $response = $this->getJson(route('api.tickets.roads.index', $ticket));

        $response->assertOk()->assertSee($road->name);
    }

    /**
     * @test
     */
    public function it_can_attach_roads_to_ticket()
    {
        $ticket = Ticket::factory()->create();
        $road = Road::factory()->create();

        $response = $this->postJson(
            route('api.tickets.roads.store', [$ticket, $road])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $ticket
                ->roads()
                ->where('roads.id', $road->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_roads_from_ticket()
    {
        $ticket = Ticket::factory()->create();
        $road = Road::factory()->create();

        $response = $this->deleteJson(
            route('api.tickets.roads.store', [$ticket, $road])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $ticket
                ->roads()
                ->where('roads.id', $road->id)
                ->exists()
        );
    }
}
