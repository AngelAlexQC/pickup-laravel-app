<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Category;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryCategoriesTest extends TestCase
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
    public function it_gets_category_categories()
    {
        $category = Category::factory()->create();
        $categories = Category::factory()
            ->count(2)
            ->create([
                'parent_category_id' => $category->id,
            ]);

        $response = $this->getJson(
            route('api.categories.categories.index', $category)
        );

        $response->assertOk()->assertSee($categories[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_category_categories()
    {
        $category = Category::factory()->create();
        $data = Category::factory()
            ->make([
                'parent_category_id' => $category->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.categories.categories.store', $category),
            $data
        );

        $this->assertDatabaseHas('categories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $category = Category::latest('id')->first();

        $this->assertEquals($category->id, $category->parent_category_id);
    }
}
