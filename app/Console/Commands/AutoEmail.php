<?php

namespace App\Console\Commands;

use App\Jobs\sendEmailToUsers;
use App\Models\Admin\Notify\Email;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:sendEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emails_to_send = Email::whereStatus(1)->where('published_at', '=', now())->get();
        foreach ($emails_to_send as $email) {
            sendEmailToUsers::dispatch($email);
        }

    }
}
