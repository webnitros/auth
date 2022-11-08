<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 07.11.2022
 * Time: 08:17
 */

namespace Tests\Feature;


use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{

    /** @test */
    public function forgot_password()
    {
        $user = $this->userFactory();


        $this->postJson('/api/password/reset', [
            'email' => $user->email
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['email']);
    }
}
