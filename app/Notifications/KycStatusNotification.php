<?php

namespace App\Notifications;

use App\Models\KycDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KycStatusNotification extends Notification
{
    use Queueable;

    protected $kycDocument;

    /**
     * Create a new notification instance.
     */
    public function __construct(KycDocument $kycDocument)
    {
        $this->kycDocument = $kycDocument;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $status = $this->kycDocument->status;
        
        if ($status === 'verified') {
            return (new MailMessage)
                ->subject('KYC Verification Approved')
                ->greeting('Hello ' . $notifiable->name . '!')
                ->line('Your KYC verification has been approved.')
                ->line('Document Type: ' . $this->kycDocument->getDocumentTypeLabel())
                ->line('You can now access all features of your account.')
                ->action('View Dashboard', url('/user/dashboard'))
                ->line('Thank you for completing your verification!');
        } else {
            return (new MailMessage)
                ->subject('KYC Verification Status Update')
                ->greeting('Hello ' . $notifiable->name . '!')
                ->line('Your KYC verification has been rejected.')
                ->line('Document Type: ' . $this->kycDocument->getDocumentTypeLabel())
                ->line('Reason: ' . ($this->kycDocument->remarks ?? 'Please check your documents and resubmit.'))
                ->action('Resubmit KYC', url('/kyc-application'))
                ->line('Please correct the issues and submit again.');
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'kyc_id' => $this->kycDocument->id,
            'status' => $this->kycDocument->status,
            'document_type' => $this->kycDocument->document_type,
            'remarks' => $this->kycDocument->remarks,
        ];
    }
}
