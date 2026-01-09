<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;
    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailforPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Permintaan Reset Password')
            ->greeting('Halo,' . $notifiable->name)
            ->line('Kami menerima permintaan untuk reset password akun Anda.')
            ->action('Reset Password', $url)
            ->line('Link ini hanya berlaku selama 60 menit.')
            ->line('Jika Anda tidak meminta reset password, abaikan saja email ini.')
            ->salutation('Terima kasih, Presensiku');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
