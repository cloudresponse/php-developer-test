<?php

namespace App\Console;

use App\Providers\UserSyncServiceProvider;
use Illuminate\Console\Command;

class ApiPingCommand extends Command
{
    protected $signature = 'sync:pingApi';

    protected $description = 'Makes a request to the API';

    public function handle()
    {
        $response = UserSyncServiceProvider::apiPing();

        if ($response->failed()) {
            $this->error('Api not available');
        }

        return $this->info('Api is available');
    }
}
