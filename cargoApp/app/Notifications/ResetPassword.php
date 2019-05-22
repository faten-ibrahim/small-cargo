<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
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
        // $link = url( "/password/reset/?token=" . $this->token );
        return (new MailMessage)
                    ->subject(config('app.name').' '.'Account Recovery')
                    ->greeting('Hi ' .$notifiable->name.',')
                    ->line('We received a request to reset your account password.')
                    ->action('Click here to reset your password.', url('password/reset', $this->token).'?email='.urlencode($notifiable->email))
                    ->line('Thanks,')
                    ->salutation('Cargo Team');
    }

    // url('password/reset', $this->token).'?email='.urlencode($notifiable->email))


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
