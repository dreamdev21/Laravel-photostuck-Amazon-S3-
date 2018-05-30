<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ArtworkStatusUpdated extends Notification
{
    use Queueable;
    protected $artwork;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($artwork)
    {
        $this->artwork = $artwork;
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
        ->subject('Artwork# '. $this->artwork->id . ' is ' . $this->artwork->statusDesc())
        ->line('Your artwork#'. $this->artwork->id .' has been updated with new status:'.$this->artwork->statusDesc())
        ->line('Also you can see all your artworks with their status in dashboard.')
        ->action('Dashboard', url('/dashboard'))
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
