<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\Ticket;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketItemsTest extends TestCase
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
    public function it_gets_ticket_items()
    {
        $ticket = Ticket::factory()->create();
        $items = Item::factory()
            ->count(2)
            ->create([
                'track_id' => $ticket->id,
            ]);

        $response = $this->getJson(route('api.tickets.items.index', $ticket));

        $response->assertOk()->assertSee($items[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_ticket_items()
    {
        $ticket = Ticket::factory()->create();
        $data = Item::factory()
            ->make([
                'track_id' => $ticket->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tickets.items.store', $ticket),
            $data
        );

        $this->assertDatabaseHas('items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $item = Item::latest('id')->first();

        $this->assertEquals($ticket->id, $item->track_id);
    }
}
