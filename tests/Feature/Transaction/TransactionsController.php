<?php

namespace Tests\Feature\Transaction;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Tests\TestCase;

class TransactionsController extends TestCase
{
    /** @test */

    public function can_see_all_transactions()
    {
        User::factory()->times(10)->create();

        Product::factory()->times(5)->create();

        Transaction::factory()->times(50)->create();

        $response = $this->get(route('transactions.index'));

        $response->assertStatus(200);

        $response->assertSee(['quantity', 'buyer_id', 'product_id']);
    }

    /** @test */

    public function can_see_a_transactions()
    {
        User::factory()->times(10)->create();

        Product::factory()->times(5)->create();

        $transaction = Transaction::factory()->times(50)->create();

        $response = $this->get(route('transactions.show', $transaction[20]->id));

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'quantity' => $transaction[20]->quantity,
                'buyer_id' => $transaction[20]->buyer_id,
                'product_id' => $transaction[20]->product_id
            ]
        ]);
    }
}
