<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendPostToSubscriberNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Hello '.$notifiable->name)
            ->line('A new post has been published on '.$this->post->website->name)
            ->line('Title: '.$this->post->title)
            ->line('Description: '.$this->post->description)
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
