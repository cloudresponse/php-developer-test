<?php

namespace App\Providers;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Ramsey\Collection\Collection;

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

    public static function getUsersFromApi(bool $allPages): Collection
    {


    }
}
