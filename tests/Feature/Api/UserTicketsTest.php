<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Ticket;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTicketsTest extends TestCase
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
    public function it_gets_user_tickets()
    {
        $user = User::factory()->create();
        $tickets = Ticket::factory()
            ->count(2)
            ->create([
                'driver_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.tickets.index', $user));

        $response->assertOk()->assertSee($tickets[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_tickets()
    {
        $user = User::factory()->create();
        $data = Ticket::factory()
            ->make([
                'driver_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.tickets.store', $user),
            $data
        );

        $this->assertDatabaseHas('tickets', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $ticket = Ticket::latest('id')->first();

        $this->assertEquals($user->id, $ticket->driver_id);
    }
}
