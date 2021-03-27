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

    /** @test */

    public function can_create_a_new_user()
    {
        $user = [
            'name' => 'Alexis',
            'email' => 'ale.maldo@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'verified' => User::UNVERIFIED_USER,
            'verification_token' => User::generateVerificationToken(),
            'admin' => User::REGULAR_USER,
        ];

        $response = $this->postJson(route('users.store', $user));

        $response->assertJson([
            'data' => [
                'name' => 'Alexis',
                'email' => 'ale.maldo@gmail.com',
                'verified' => User::UNVERIFIED_USER,
                'admin' => User::REGULAR_USER,
            ]
        ]);

        $this->assertDatabaseCount('users', 1);

    }

    /** @test */

    public function can_see_an_users()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $response = $this->getJson(route('users.show', 1));

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'verified' => $user->verified,
                'admin' => $user->admin,
            ]
        ]);
    }

    /** @test */

    public function can_update_an_user()
    {
        $user = User::factory()->times(5)->create();

        $this->assertDatabaseHas('users', [
            'name' => strtolower($user[0]->name),
            'email' => $user[0]->email,
            'verified' => $user[0]->verified,
            'admin' => $user[0]->admin
        ]);

        $user_update = [
            'name' => 'Alex',
            'email' => 'ale.maldo2@gmail.com',
        ];

        $response = $this->putJson(route('users.update', 1), $user_update);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'Alex',
                    'email' => 'ale.maldo2@gmail.com',
                    'verified' => $user[0]->verified,
                    'admin' => $user[0]->admin
                ]
            ]);
    }

    /** @test */

    public function can_delete_an_user()
    {
        $user = User::factory()->times(5)->create();

        $this->assertDatabaseHas('users', [
            'name' => strtolower($user[0]->name),
            'email' => $user[0]->email,
            'verified' => $user[0]->verified,
            'admin' => $user[0]->admin
        ]);

        $response = $this->deleteJson(route('users.update', 1));

        $this->assertDatabaseMissing('users', [
            'id' => $user[0]->id
        ]);

        $response->assertStatus(204);

    }
}
