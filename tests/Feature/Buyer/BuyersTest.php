<?php

namespace Tests\Feature\Buyer;

use App\Models\Buyer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Tests\TestCase;

class BuyersTest extends TestCase
{
    /** @test */

    public function can_see_all_buyers()
    {
        $this->withoutExceptionHandling();

        User::factory()->times(20)->create();

        Product::factory()->times(20)->create();

        $transaction = Transaction::factory()->times(2)->create([
            'buyer_id' => 5
        ]);

        $response = $this->getJson(route('buyers.index'));

        $this->assertTrue(
            Buyer::find($transaction[0]->buyer_id)
                ->transactions
                ->contains($transaction[0])
        );

        $response->assertStatus(200)
            ->assertSee([
                'id', 'name', 'email', 'verified', 'admin'
            ]);;
    }

    /** @test */

    public function can_see_a_buyer()
    {
        $user = User::factory()->times(10)->create();

        Product::factory()->times(5)->create();

        Transaction::factory()->times(2)->create([
            'buyer_id' => $user[0]->id
        ]);

        $response = $this->getJson(route('buyers.show', $user[0]->id));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $user[0]->id,
                    'name' => $user[0]->name,
                    'email' => $user[0]->email,
                    'verified' => $user[0]->verified,
                    'admin' => $user[0]->admin
                ]
            ]);
    }
}
