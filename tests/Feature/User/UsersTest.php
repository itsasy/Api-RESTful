<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\TestCase;

class UsersTest extends TestCase
{

    /** @test */

    public function can_see_a_list_of_users()
    {
        $this->withoutExceptionHandling();

        $users = User::factory()->times(5)->create();

        $response = $this->getJson(route('users.index'));

        $response->assertStatus(200);

        $response->assertSee([
            'id' => $users[0]->id,
            'name' => $users[0]->name,
            'email' => $users[0]->email,
            'verified' => $users[0]->verified,
            'admin' => $users[0]->admin,
        ]);
    }
}
