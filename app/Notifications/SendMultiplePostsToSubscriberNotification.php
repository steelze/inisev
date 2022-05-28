<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMultiplePostsToSubscriberNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $posts;

    public function __construct($posts)
    {
        $this->posts = $posts;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject('Hello '.$notifiable->name)
            ->line('Do not miss out on this new posts');
        
        foreach ($this->posts as $post) {
            $mailMessage = $mailMessage
                ->line('Title: '.$post->title)
                ->line('Description: '.$post->description)
                ->line('');
        }

        return $mailMessage->line('Thank you for using our application!');
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
