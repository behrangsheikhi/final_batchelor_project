<?php

namespace App\Http\Services\Message;

use App\Http\Interfaces\MessageInterface;

class MessageService
{
    private MessageInterface $message;

    public function __construct(MessageInterface $messageInterface)
    {
        $this->message = $messageInterface;
    }

    public function send()
    {
        return $this->message->fire();
    }
}


