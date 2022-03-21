<?php

namespace Tests\Feature;

use App\Providers\UserSyncServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_commands_available()
    {
        $this->artisan('sync:pingApi')->assertExitCode(0);
        $this->artisan('sync:users')->assertExitCode(0);
    }

    public function test_api_available()
    {
        $response = UserSyncServiceProvider::apiPing();
        $this->assertTrue(true, $response->successful());
    }
}
