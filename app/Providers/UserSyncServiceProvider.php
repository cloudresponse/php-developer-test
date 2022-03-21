<?php

namespace App\Providers;

use App\Data\UserDto;
use App\Models\User;
use Error;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use function PHPUnit\Framework\throwException;

class UserSyncServiceProvider extends ServiceProvider
{


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public static function apiPing(): Response
    {
        return Http::get('https://reqres.in/api/users', ['page' => 1]);
    }


    public static function getUsersFromApi(bool $allPages = false): \Illuminate\Support\Collection
    {
        // Should be in env.
        $url = 'https://reqres.in/api/users';

        // Todo - This Needs to be refactored into an action etc.

        $response = Http::get($url);

        if ($response->failed()) throwException($response->toException());

        $page = $response['page'];
        $totalPages = $response['total_pages'];

        if (!$allPages) {
            return $response->collect('data')->map(function ($item) {
                return new UserDto(
                    id: $item['id'],
                    email: $item['email'],
                    name: $item['first_name'] . " " . $item['last_name'],
                    first_name: $item['first_name'],
                    last_name: $item['last_name'],
                    avatar: $item['avatar'],
                    password: Hash::make('supersecurepassword')
                );
            });
        }

        $users = collect();


        for ($page; $page <= $totalPages; $page++) {
            $response = Http::get($url, ['page' => $page]);
            if ($response->failed()) throwException($response->toException());

            $response->collect('data')->each(function ($item) use ($users) {
                $users->push($item);
            });
        }

        return $users->map(function ($item) {
            return new UserDto(
                id: $item['id'],
                email: $item['email'],
                name: $item['first_name'] . " " . $item['last_name'],
                first_name: $item['first_name'],
                last_name: $item['last_name'],
                avatar: $item['avatar'],
                password: Hash::make('supersecurepassword')
            );
        });

    }

    public static function syncUsers(array $users)
    {
        try {
            // Upsert should insert or update en mass. Need to confim whether generated passwords would overwrite.
            User::upsert($users, ['id'], ['name', 'first_name', 'last_name', 'email', 'avatar']);

        } catch (Error$exception) {
            throw new $exception;
        }
    }
}
