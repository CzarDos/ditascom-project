<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CertificateRequest;

class CertificateApprovedNotification extends Notification
{
    use Queueable;

    protected $certificateRequest;

    public function __construct(CertificateRequest $certificateRequest)
    {
        $this->certificateRequest = $certificateRequest;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Certificate Request Approved - DITASCOM')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your ' . $this->certificateRequest->certificate_type . ' certificate request has been approved!')
            ->line('**Request ID:** REQ-' . str_pad($this->certificateRequest->id, 4, '0', STR_PAD_LEFT))
            ->line('**Certificate Type:** ' . $this->certificateRequest->certificate_type)
            ->line('**Status:** Approved - Processing')
            ->line('We are now processing your certificate. You will receive another email when it is ready for download.')
            ->line('Thank you for your patience!')
            ->salutation("Regards,\nDITASCOM Staff");
    }
}
