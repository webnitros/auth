<?php

namespace Tests\Feature;

use AuthModel\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    /** @test */
    public function update_profile_info()
    {
        $user = $this->userFactory();
        $this->actingAs($user)
            ->patchJson('/api/settings/profile', [
                'name' => 'Test User',
                'email' => 'test@test.app',
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'name', 'email']);

        self::assertEquals('test@test.app', $user->get('email'));
    }

    /** @test */
    public function update_password()
    {
        $user = $this->userFactory();
        $this->actingAs($user)
            ->patchJson('/api/settings/password', [
                'password' => 'updated',
                'password_confirmation' => 'updated',
            ])
            ->assertSuccessful();

        #$this->assertTrue(Hash::check('updated', $user->password));
    }
}
