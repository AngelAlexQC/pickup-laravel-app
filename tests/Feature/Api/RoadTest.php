<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Road;

use App\Models\Address;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoadTest extends TestCase
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
    public function it_gets_roads_list()
    {
        $roads = Road::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.roads.index'));

        $response->assertOk()->assertSee($roads[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_road()
    {
        $data = Road::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.roads.store'), $data);

        $this->assertDatabaseHas('roads', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_road()
    {
        $road = Road::factory()->create();

        $address = Address::factory()->create();
        $address = Address::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'meta' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'address_start_id' => $address->id,
            'address_end_id' => $address->id,
        ];

        $response = $this->putJson(route('api.roads.update', $road), $data);

        $data['id'] = $road->id;

        $this->assertDatabaseHas('roads', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_road()
    {
        $road = Road::factory()->create();

        $response = $this->deleteJson(route('api.roads.destroy', $road));

        $this->assertSoftDeleted($road);

        $response->assertNoContent();
    }
}
