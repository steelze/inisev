<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use App\Notifications\SendMultiplePostsToSubscriberNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SendMultiplePostToSubscriberJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        DB::transaction(function() {
            $websitesId = implode(', ', $this->user->websites->pluck('id')->toArray());

            $posts = DB::select(DB::raw("select posts.* from `posts` left join `post_user` on `post_user`.`post_id` = `posts`.`id` AND `post_user`.`user_id` = ? where `post_user`.`post_id` is null and `website_id` in ($websitesId)"), [$this->user->id]);

            
            if ($posts) {
                $this->user->posts()->attach(collect($posts)->pluck('id')->toArray());
                $this->user->notify(new SendMultiplePostsToSubscriberNotification($posts));
            }
        });
    }
}
