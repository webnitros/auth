<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * Корректные данные прохождения регистрации
     * @test
     */
    public function can_register()
    {
        $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@test.app',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'name', 'email']);
    }

    /**
     * Некорректные данные, будет возвращаться ответ json
     * @test
     */
    public function can_register_not_correct()
    {
        $this->postJson('/api/register', [
            #'name' => 'Test User',
            'email' => 'test@test.apptest@test.app',
            'password' => 'secre',
            'password_confirmation' => 'secret',
        ])
            ->assertUnprocessable()
            ->assertJsonStructure(['data', 'reason']);
    }

}
