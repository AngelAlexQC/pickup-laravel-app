<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Road;
use App\Models\Address;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoadAddressesTest extends TestCase
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
    public function it_gets_road_addresses()
    {
        $road = Road::factory()->create();
        $addresses = Address::factory()
            ->count(2)
            ->create([
                'waypoint_road_id' => $road->id,
            ]);

        $response = $this->getJson(route('api.roads.addresses.index', $road));

        $response->assertOk()->assertSee($addresses[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_road_addresses()
    {
        $road = Road::factory()->create();
        $data = Address::factory()
            ->make([
                'waypoint_road_id' => $road->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.roads.addresses.store', $road),
            $data
        );

        $this->assertDatabaseHas('addresses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $address = Address::latest('id')->first();

        $this->assertEquals($road->id, $address->waypoint_road_id);
    }
}
