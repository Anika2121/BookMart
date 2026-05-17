<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto delete accounts requested for deletion after 7 days
Schedule::command('accounts:delete-requested')->daily();

// Recalculate book scores every 6 hours
Schedule::command('books:recalculate-scores')->everySixHours();