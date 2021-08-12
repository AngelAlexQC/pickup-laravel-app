<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Address;

use App\Models\Road;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressTest extends TestCase
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
    public function it_gets_addresses_list()
    {
        $addresses = Address::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.addresses.index'));

        $response->assertOk()->assertSee($addresses[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_address()
    {
        $data = Address::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.addresses.store'), $data);

        $this->assertDatabaseHas('addresses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_address()
    {
        $address = Address::factory()->create();

        $road = Road::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'meta' => $this->faker->text,
            'waypoint_road_id' => $road->id,
        ];

        $response = $this->putJson(
            route('api.addresses.update', $address),
            $data
        );

        $data['id'] = $address->id;

        $this->assertDatabaseHas('addresses', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_address()
    {
        $address = Address::factory()->create();

        $response = $this->deleteJson(route('api.addresses.destroy', $address));

        $this->assertSoftDeleted($address);

        $response->assertNoContent();
    }
}
