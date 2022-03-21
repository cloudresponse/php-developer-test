<?php

namespace Tests\Feature;

use App\Data\UserDto;
use App\Providers\UserSyncServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_pingApi()
    {
        $this->artisan('sync:pingApi')->assertExitCode(0);
    }

    public function test_command_syncUsers()
    {
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
        $this->artisan('sync:users');
        // Check the users is at the right count for the scenario
        $this->assertDatabaseCount('users', 6);
        // Check the right properties exist on a user.s
        $this->assertDatabaseHas('users', [
            'id' => 1,
            'email' => 'george.bluth@reqres.in'
        ]);
    }

    public function test_get_first_page_of_users()
    {
        $users = UserSyncServiceProvider::getUsersFromApi();

        // Can we match this against a DTO attributes?
        $this->assertTrue($users->has(UserDto::attributes()));
        // Check the count of all users. Should be 6.
        $this->assertCount(6, $users);
    }

    public function test_get_all_pages_of_users()
    {
        $users = UserSyncServiceProvider::getUsersFromApi(allPages: true);

        $this->assertTrue($users->has(UserDto::attributes()));
        // Check the count of all users. Should be 12.
        $this->assertCount(12, $users);
    }
}
