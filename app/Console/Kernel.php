<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\CleanOldTransactions;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CleanOldTransactions::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // run cleanup on the first day of each month
        $schedule->command('transactions:cleanup --days=30')->monthlyOn(1, '01:00');
    }

    protected function commands()
    {
        //
    }
}
