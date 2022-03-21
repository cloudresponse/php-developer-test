<?php

namespace App\Console;

use App\Providers\UserSyncServiceProvider;
use Illuminate\Console\Command;

class SyncUsersCommand extends Command
{
    protected $signature = 'sync:users {--all}';

    protected $description = 'Sync users from API';

    public function handle()
    {
        $this->info('Starting sync task...');
        $users = UserSyncServiceProvider::getUsersFromApi($this->option('all'));
        $this->warn('Users to sync: ' . $users->count());
        UserSyncServiceProvider::syncUsers($users->toArray());
        $this->info('Sync completed');
    }
}
