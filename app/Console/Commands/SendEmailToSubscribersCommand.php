<?php

namespace App\Console\Commands;

use App\Jobs\SendMultiplePostToSubscriberJob;
use App\Models\User;
use Illuminate\Console\Command;

class SendEmailToSubscribersCommand extends Command
{
    protected $signature = 'send:mail:subscribers';

    protected $description = 'Send email to subscribers';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info('****** Starting Command **********');
        User::with('websites')->chunkById(100, function($users) {
            foreach ($users as $user) {
                if ($user->websites->isEmpty()) continue;
                SendMultiplePostToSubscriberJob::dispatch($user);
            }
        });
        $this->info('****** Ending Command **********');
        return 0;
    }
}
