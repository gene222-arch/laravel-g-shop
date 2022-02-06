<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VerificationControllerTest extends TestCase
{
    /**
     * test
     */
    public function user_can_verify_email_address()
    {
        $notification = new EmailVerificationNotification();

        $user = User::factory()->unverified()->create();
        $uri = $notification->verificationUrl($user);

        $appUrl = env('APP_URL') . '/api';
        $reactAppUrl = env('REACT_APP_URL');
        $uri = str_replace($reactAppUrl, $appUrl, $uri);

        $this->assertSame(NULL, $user->email_verified_at);

        $response = $this->actingAs($user, 'api')->get($uri);

        $response->assertSuccessful();
        $this->assertNotNull($user->email_verified_at);
    }
}
