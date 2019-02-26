<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GetUserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetUserReturnWithoutPassword()
    {
        Passport::actingAs(
            factory(User::class)->create()
        );

        $response = $this->get('/api/user');

        $response->assertStatus(200);
        $this->assertArrayHasKey('name', $response->json());
        $this->assertArrayNotHasKey('password', $response->json());
    }
}
