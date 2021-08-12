<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Road;

use App\Models\Address;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoadControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_roads()
    {
        $roads = Road::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('roads.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.roads.index')
            ->assertViewHas('roads');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_road()
    {
        $response = $this->get(route('roads.create'));

        $response->assertOk()->assertViewIs('app.roads.create');
    }

    /**
     * @test
     */
    public function it_stores_the_road()
    {
        $data = Road::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('roads.store'), $data);

        $this->assertDatabaseHas('roads', $data);

        $road = Road::latest('id')->first();

        $response->assertRedirect(route('roads.edit', $road));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_road()
    {
        $road = Road::factory()->create();

        $response = $this->get(route('roads.show', $road));

        $response
            ->assertOk()
            ->assertViewIs('app.roads.show')
            ->assertViewHas('road');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_road()
    {
        $road = Road::factory()->create();

        $response = $this->get(route('roads.edit', $road));

        $response
            ->assertOk()
            ->assertViewIs('app.roads.edit')
            ->assertViewHas('road');
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

        $response = $this->put(route('roads.update', $road), $data);

        $data['id'] = $road->id;

        $this->assertDatabaseHas('roads', $data);

        $response->assertRedirect(route('roads.edit', $road));
    }

    /**
     * @test
     */
    public function it_deletes_the_road()
    {
        $road = Road::factory()->create();

        $response = $this->delete(route('roads.destroy', $road));

        $response->assertRedirect(route('roads.index'));

        $this->assertSoftDeleted($road);
    }
}
