<?php

namespace Tests\Feature\Seller;

use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Tests\TestCase;

class SellersTest extends TestCase
{
    /** @test */

    public function can_see_all_sellers()
    {
        $this->withoutExceptionHandling();

        $users = User::factory()->times(100)->create();

        $products = Product::factory()->times(20)->create([
            'seller_id' => $users[0]->id
        ]);

        $response = $this->getJson(route('sellers.index'));

        $this->assertTrue(
            Seller::find($users[0]->id)
                ->products
                ->contains($products[0])
        );

        $response->assertStatus(200)
            ->assertSee([
                'id', 'name', 'email', 'verified', 'admin'
            ]);;
    }

    /** @test */

    public function can_see_a_seller()
    {
        $users = User::factory()->times(10)->create();

        Product::factory()->times(5)->create([
            'seller_id' => $users[0]->id
        ]);

        $response = $this->getJson(route('sellers.show', $users[0]->id));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $users[0]->id,
                    'name' => $users[0]->name,
                    'email' => $users[0]->email,
                    'verified' => $users[0]->verified,
                    'admin' => $users[0]->admin
                ]
            ]);
    }
}
