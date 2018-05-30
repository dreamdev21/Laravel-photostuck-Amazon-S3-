<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ContributorStatusUpdated extends Notification
{
    use Queueable;
    protected $contributor;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($contributor)
    {
        $this->contributor = $contributor;
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
        ->subject('Your contributor account is now '.$this->contributor->statusDesc())
        ->line('Your contributor account has been updated with status: '. $this->contributor->statusDesc())
        ->line('Usually the account is being rejected if the information you provide is incorrect or misleading.')
        ->line('If you want to know more about this, please contact us.')
        ->action('Go to website', url('/'))
        ->line('Thank you for using our application!');
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
