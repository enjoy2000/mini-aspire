<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BaseTestCase extends TestCase
{
    use RefreshDatabase;

    public function login()
    {
        $user = factory(User::class)->create();  # TODO create scope to create-loan
        Passport::actingAs(
            $user
        );

        return $user;
    }
}
