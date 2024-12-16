<?php

namespace App\Jobs;

use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Models\Admin\Notify\SMS;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSMSToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $message;

    /**
     * Create a new job instance.
     */
    public function __construct(SMS $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::whereNotNull('mobile')
            ->whereActivation(1)
            ->where('mobile_verified_at', '!=', null)
            ->whereStatus(1)
            ->get();
        foreach ($users as $user) {
            $service = new SmsService();
            $service->setFrom(\Config::get('sms.otp_from'));
            $service->setTo([$user->mobile]);
            $service->setText($this->message->body);
            $service->setIsFlash(true);

            $messageService = new MessageService($service);
            $messageService->send();
        }
    }
}
