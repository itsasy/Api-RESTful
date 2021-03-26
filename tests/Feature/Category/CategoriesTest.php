<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    /** @test */
    public function can_see_all_categories()
    {
        $this->withoutExceptionHandling();

        Category::factory()->times(10)->create();

        $response = $this->getJson(route('categories.index'));

        $response->assertStatus(200);

        $response->assertSee([
            'name', 'description'
        ]);
    }

    /** @test */

    public function can_create_a_category()
    {
        $this->withoutExceptionHandling();

        $category = Category::factory()->raw();

        $response = $this->postJson(route('categories.store'), $category);

        $this->assertDatabaseHas('categories', $category);
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $category['name'],
                    'description' => $category['description'],
                ]
            ]);
    }

    /** @test */

    public function can_see_a_category()
    {
        $this->withoutExceptionHandling();

        $categories = Category::factory()->times(100)->create();

        $response = $this->getJson(route('categories.show', $categories[20]->id));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $categories[20]->name,
                    'description' => $categories[20]->description,
                ]
            ]);
    }

    /** @test */

    public function can_update_a_category()
    {
        $this->withoutExceptionHandling();

        $categories = Category::factory()->times(100)->create();

        $category_update = ['name' => 'Category 1'];

        $response = $this->putJson(route('categories.update', $categories[20]->id), $category_update);

        $this->assertDatabaseHas('categories', $category_update);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $category_update['name'],
                    'description' => $categories[20]->description,
                ]
            ]);
    }

    /** @test */

    public function can_delete_a_category()
    {
        $this->withoutExceptionHandling();

        $categories = Category::factory()->times(100)->create();

        $this->assertDatabaseHas('categories', $category = [
            'id' => $categories[35]->id,
            'name' => $categories[35]->name,
            'description' => $categories[35]->description,
        ]);

        $response = $this->deleteJson(route('categories.destroy', $categories[35]->id));

        $this->assertDatabaseMissing('categories', [
            $category
        ]);

        $response->assertStatus(204);
    }
}
