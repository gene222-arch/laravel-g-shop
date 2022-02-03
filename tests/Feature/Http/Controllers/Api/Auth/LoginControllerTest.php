<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * @test
    */
    public function user_receive_valid_json_response_on_login()
    {
        $data = [
            "email" => "gleason.dorcas@example.net",
            "password" => "password"
        ];

        $response = $this->post("/api/auth/login", $data);

        $response->assertJsonStructure([
            'data' => [
                "access_token",
                "token_type",
                "expired_at"
            ],
            'message',
            'status',
            'status_message'
        ]);
    }

    /**
     * @test
    */
    public function unverified_email_not_able_to_login()
    {
        $user = User::factory()
            ->unverified()
            ->create();

        $data = [
            "email" => $user->email,
            "password" => $user->password
        ];

        $response = $this->post("/api/auth/login", $data);
        
        $response->assertForbidden();
    }
}
