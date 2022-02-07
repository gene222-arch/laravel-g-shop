<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use WithFaker;

    /**
     * test
    */
    public function user_can_register_wtih_specified_json_structure()
    {
        $data = [
            'name' => $this->faker()->unique()->name(),
            'email' => $this->faker()->unique()->email(),
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->post('/api/auth/register', $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'access_token',
                'token_type',
                'expired_at'
            ],
            'message',
            'status',
            'status_message'
        ]);
    }
}
