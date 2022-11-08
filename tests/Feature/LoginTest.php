<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{

    /** @test */
    public function authenticate()
    {
        $user = $this->userFactory();
        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['token', 'expires_in'])
            ->assertJson(['token_type' => 'bearer']);
    }

    /** @test */
    public function fetch_the_current_user()
    {
        $this->actingAs($this->userFactory())
            ->getJson('/api/user')
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'name', 'email']);
    }

    /** @test */
    public function log_out()
    {
        $token = $this->postJson('/api/login', [
            'email' => $this->userFactory()->email,
            'password' => 'password',
        ])->json()['token'];

        $this->postJson("/api/logout?token=$token")
            ->assertSuccessful();

        $this->getJson("/api/user?token=$token")
            ->assertStatus(401);
    }
}
