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

    public function test_users_exist_in_db()
    {
        // Sync users
        // Check the users is at the right count for the scenario
        // Check the right properties exist on a user.
    }

    public function test_get_first_page_of_users()
    {
        $users = UserSyncServiceProvider::getUsersFromApi();

        // Can we match this against a DTO?

        // Check the count of all users. Should be 6.
    }

    public function test_get_all_pages_of_users()
    {
        $users = UserSyncServiceProvider::getUsersFromApi(allPages: true);

        // Can we match this against a DTO?

        // Check the count of all users. Should be 12.
    }
}
