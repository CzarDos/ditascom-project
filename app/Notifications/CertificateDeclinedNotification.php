<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CertificateRequest;

class CertificateDeclinedNotification extends Notification
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
        $message = (new MailMessage)
            ->subject('Certificate Request Update - DITASCOM')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We regret to inform you that your ' . $this->certificateRequest->certificate_type . ' certificate request could not be approved at this time.')
            ->line('**Request ID:** REQ-' . str_pad($this->certificateRequest->id, 4, '0', STR_PAD_LEFT))
            ->line('**Certificate Type:** ' . $this->certificateRequest->certificate_type);

        if ($this->certificateRequest->admin_remarks) {
            $message->line('**Reason:** ' . $this->certificateRequest->admin_remarks);
        }

        $message->line('If you have any questions or would like to submit a new request, please contact us.')
            ->line('Thank you for your understanding.')
            ->salutation("Regards,\nDITASCOM Staff");

        return $message;
    }
}
