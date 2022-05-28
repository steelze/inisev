<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\Website;
use App\Notifications\SendPostToSubscriberNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class SendPostToSubscribersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle(): void
    {
        DB::transaction(function() {
            $website = Website::with('users')->find($this->post->website_id);
            $users = $website->users;
            
            $this->post->users()->attach($users);
            Notification::send($users, new SendPostToSubscriberNotification($this->post));
        });
    }
}
