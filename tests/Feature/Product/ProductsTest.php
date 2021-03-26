<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    /**
     * @test
     */
    public function can_see_a_list_of_products()
    {
        $this->withoutExceptionHandling();

        User::factory()->times(10)->create();

        $products = Product::factory()->times(5)->create();

        $response = $this->getJson(route('products.index'));

        $response->assertStatus(200)
            ->assertSee([
                'id' => $products[0]->id,
                'name' => $products[0]->name,
                'description' => $products[0]->description,
                'quantity' => $products[0]->quantity,
                'status' => $products[0]->status,
                'image' => $products[0]->image,
                'price' => $products[0]->price,
                'seller_id' => $products[0]->seller_id
            ]);
    }

    /**
     * @test
     */
    public function can_see_an_product()
    {
        $this->withoutExceptionHandling();

        User::factory()->times(10)->create();

        $products = Product::factory()->times(5)->create();

        $response = $this->getJson(route('products.show', $products[0]->id));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $products[0]->id,
                    'name' => $products[0]->name,
                    'description' => $products[0]->description,
                    'quantity' => $products[0]->quantity,
                    'status' => $products[0]->status,
                    'image' => $products[0]->image,
                    'seller_id' => $products[0]->seller_id
                ]
            ]);
    }
}
