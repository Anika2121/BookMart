<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteRequestedAccounts extends Command
{
    protected $signature   = 'accounts:delete-requested';
    protected $description = 'Delete accounts that requested deletion 7 days ago';

    public function handle(): void
    {
        $count = User::whereNotNull('delete_requested_at')
            ->where('delete_requested_at', '<=', now()->subDays(7))
            ->count();

        User::whereNotNull('delete_requested_at')
            ->where('delete_requested_at', '<=', now()->subDays(7))
            ->delete();

        $this->info("{$count} accounts have been deleted.");
    }
}