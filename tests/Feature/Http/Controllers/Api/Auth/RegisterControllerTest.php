<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    /**
     * test
    */
    public function user_receive_valid_json_response_on_register()
    {
        $data = [
            "name" => "kokoro ",
            "email" => "gleason.dorcass@example.net",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $response = $this->post("/api/auth/register", $data);

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
}
