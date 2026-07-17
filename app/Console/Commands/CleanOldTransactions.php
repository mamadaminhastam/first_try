<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Carbon\Carbon;

class CleanOldTransactions extends Command
{
    protected $signature = 'transactions:cleanup {--days=30}';
    protected $description = 'Delete transactions older than given days (default 30)';

    public function handle()
    {
        $days = (int) $this->option('days');
        $cutoff = Carbon::now()->subDays($days);
        $count = Transaction::where('created_at', '<', $cutoff)->delete();
        $this->info("Deleted {$count} transactions older than {$days} days.");
        return 0;
    }
}
