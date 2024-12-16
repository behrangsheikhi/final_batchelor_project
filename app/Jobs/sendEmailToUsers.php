<?php

namespace App\Jobs;

use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Models\Admin\Notify\Email;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sendEmailToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;

    /**
     * Create a new job instance.
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::whereNotNull('email')
            ->whereActivation(1)
            ->where('email_verified_at', '!=', null)
            ->whereStatus(1)
            ->get();
        foreach ($users as $user) {
            $service = new EmailService();
            $details = [
                'title' => $this->email->subject,
                'body' => $this->email->body,
            ];
            $files = $this->email->files;
            $filePaths = [];
            foreach ($files as $file) {
                $filePaths[] = $file->file_path;
            }
            $service->setDetails($details);
            $service->setFrom('behrangsheikhi@hotmail.com', 'test');
            $service->setSubject($this->email->subject);
            $service->setTo($users);
            $service->setFiles($filePaths);
            $message_service = new MessageService($service);
            $message_service->send();
        }


    }
}
