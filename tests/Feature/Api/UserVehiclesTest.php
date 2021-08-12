<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserVehiclesTest extends TestCase
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
    public function it_gets_user_vehicles()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();

        $user->vehicles()->attach($vehicle);

        $response = $this->getJson(route('api.users.vehicles.index', $user));

        $response->assertOk()->assertSee($vehicle->name);
    }

    /**
     * @test
     */
    public function it_can_attach_vehicles_to_user()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();

        $response = $this->postJson(
            route('api.users.vehicles.store', [$user, $vehicle])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->vehicles()
                ->where('vehicles.id', $vehicle->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_vehicles_from_user()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();

        $response = $this->deleteJson(
            route('api.users.vehicles.store', [$user, $vehicle])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->vehicles()
                ->where('vehicles.id', $vehicle->id)
                ->exists()
        );
    }
}
