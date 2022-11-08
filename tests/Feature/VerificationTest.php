<?php

namespace Tests\Feature;

use AuthModel\Helpers\UrlGenerator;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class VerificationTest extends TestCase
{
    /** @test */
    public function can_verify_email()
    {
        $user = $this->userFactory(['email_verified_at' => null]);

        /* @var UrlGenerator $url */
        $url = $this->app->make('url');
        $url = $url->temporarySignedRoute('api.email.verify', now()->addMinutes(60), ['user' => $user->id]);

        $this->postJson($url)
            ->assertSuccessful()
            ->assertJsonFragment(['status' => 'Your email has been verified!']);

    }

    /** @test */
    public function can_not_verify_if_url_has_invalid_signature()
    {
        $user = $this->userFactory(['email_verified_at' => null]);
        $this->postJson("/api/email/verify/{$user->id}")
            ->assertStatus(400)
            ->assertJsonFragment(['status' => 'The verification link is invalid.']);
    }

    /** @test */
    public function resend_verification_notification()
    {
        $user = $this->userFactory(['email_verified_at' => null]);
        $this->actingAs($user)
            ->postJson('/api/email/resend', ['email' => $user->email])
            ->assertSuccessful();

    }

    /** @test */
    public function can_not_resend_verification_notification_if_email_does_not_exist()
    {
        $this->postJson('/api/email/resend', ['email' => 'foo@bar.com'])
            ->assertStatus(422)
            ->assertJsonFragment(['errors' => ['email' => ['We can\'t find a user with that e-mail address.']]]);
    }

    /** @test */
    public function can_not_resend_verification_notification_if_email_already_verified()
    {
        $user = User::factory()->create();

        Notification::fake();

        $this->postJson('/api/email/resend', ['email' => $user->email])
            ->assertStatus(422)
            ->assertJsonFragment(['errors' => ['email' => ['The email is already verified.']]]);

        Notification::assertNotSentTo($user, VerifyEmail::class);
    }
}
