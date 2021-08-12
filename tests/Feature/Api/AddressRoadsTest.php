<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Road;
use App\Models\Address;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressRoadsTest extends TestCase
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
    public function it_gets_address_roads()
    {
        $address = Address::factory()->create();
        $roads = Road::factory()
            ->count(2)
            ->create([
                'address_end_id' => $address->id,
            ]);

        $response = $this->getJson(
            route('api.addresses.roads.index', $address)
        );

        $response->assertOk()->assertSee($roads[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_address_roads()
    {
        $address = Address::factory()->create();
        $data = Road::factory()
            ->make([
                'address_end_id' => $address->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.addresses.roads.store', $address),
            $data
        );

        $this->assertDatabaseHas('roads', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $road = Road::latest('id')->first();

        $this->assertEquals($address->id, $road->address_end_id);
    }
}
