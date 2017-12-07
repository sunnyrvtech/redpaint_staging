<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetNotification extends Notification
{
    use Queueable;

    public $token;
    public $username;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $username)
    {
        $this->token = $token;
        $this->username = $username;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Password Reset from AutoLightHouse')
                        ->greeting('Hello ' . $this->username . ',')
                        ->line([
                            'You have recently requested for a password reset on your account.',
                            'You will need to confirm this request by clicking on the following link to reset your password:',
                        ])
                        ->action('Reset Password', route('password-reset', $this->token))
                        ->line([
                            'If you did not request for this email, please ignore it as it was sent automatically.',
                            'If you have any questions, please contact us at <a href="support@autolighthouse.com">support@autolighthouse.com</a>'
                            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
