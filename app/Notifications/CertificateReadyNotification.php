<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CertificateRequest;

class CertificateReadyNotification extends Notification
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
            ->subject('Your Certificate is Ready for Download - DITASCOM')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Great news! Your ' . $this->certificateRequest->certificate_type . ' certificate request has been processed and is now ready for download.')
            ->line('**Request ID:** REQ-' . str_pad($this->certificateRequest->id, 4, '0', STR_PAD_LEFT))
            ->line('**Certificate Type:** ' . $this->certificateRequest->certificate_type)
            ->action('Download Certificate', route('parishioner.certificates.download', $this->certificateRequest->id))
            ->line('You can log in to your account to download your certificate at any time.')
            ->line('Thank you for using DITASCOM!')
            ->salutation("Regards,\nDITASCOM Staff");
    }
}
