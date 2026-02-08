<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CertificateRequest;
use Carbon\Carbon;

class CleanupUnpaidRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'requests:cleanup-unpaid {--days=7 : Number of days old to delete}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete unpaid certificate requests older than specified days (default: 7 days)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        
        $this->info("Searching for unpaid requests older than {$days} days...");
        
        // Find unpaid requests older than specified days
        $oldUnpaidRequests = CertificateRequest::where('payment_status', 'unpaid')
            ->where('created_at', '<', Carbon::now()->subDays($days))
            ->get();
        
        $count = $oldUnpaidRequests->count();
        
        if ($count === 0) {
            $this->info('No unpaid requests found to delete.');
            return 0;
        }
        
        $this->warn("Found {$count} unpaid request(s) to delete.");
        
        if ($this->confirm('Do you want to proceed with deletion?')) {
            // Delete the requests
            CertificateRequest::where('payment_status', 'unpaid')
                ->where('created_at', '<', Carbon::now()->subDays($days))
                ->delete();
            
            $this->info("Successfully deleted {$count} unpaid request(s).");
            return 0;
        }
        
        $this->info('Deletion cancelled.');
        return 0;
    }
}
