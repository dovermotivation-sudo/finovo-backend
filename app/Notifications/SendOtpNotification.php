<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Otp;

class SendOtpNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param string $otp The plain text OTP to be sent
     */
    public function __construct(
        public string $otp
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        // The OTP is already in plain text when passed to the constructor
        $otp = $this->otp;
        
        return (new MailMessage)
            ->subject('Your OTP for Grow Max Account Verification')
            ->line('Your OTP for account verification is:')
            ->line('## ' . $otp) // This will show the plain text OTP
            ->line('This OTP is valid for 30 minutes.')
            ->line('If you did not request this, no further action is required.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'otp' => $this->otp
        ];
    }
}
