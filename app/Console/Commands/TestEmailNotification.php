<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\CertificateRequest;
use App\Notifications\CertificateApprovedNotification;
use App\Notifications\CertificateReadyNotification;
use Illuminate\Support\Facades\Mail;

class TestEmailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email} {--type=approved}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email notifications for DITASCOM certificate system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $type = $this->option('type');
        
        $this->info("Testing email notification to: {$email}");
        $this->info("Notification type: {$type}");
        
        // Create a test user
        $testUser = new User();
        $testUser->name = 'Test User';
        $testUser->email = $email;
        
        // Create a mock certificate request
        $mockRequest = new CertificateRequest();
        $mockRequest->id = 999;
        $mockRequest->certificate_type = 'baptismal';
        $mockRequest->first_name = 'John';
        $mockRequest->last_name = 'Doe';
        $mockRequest->status = $type === 'ready' ? 'ready' : 'approved';
        
        try {
            if ($type === 'approved') {
                $testUser->notify(new CertificateApprovedNotification($mockRequest));
                $this->info('✅ Certificate Approved notification sent successfully!');
            } elseif ($type === 'ready') {
                $testUser->notify(new CertificateReadyNotification($mockRequest));
                $this->info('✅ Certificate Ready notification sent successfully!');
            } else {
                $this->error('Invalid type. Use: approved or ready');
                return;
            }
            
            $this->info("📧 Check {$email} for the test notification email.");
            
        } catch (\Exception $e) {
            $this->error('❌ Failed to send email: ' . $e->getMessage());
        }
    }
}
