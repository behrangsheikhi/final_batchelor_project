<?php

namespace App\Http\Services\Message\Email;

use App\Http\Interfaces\MessageInterface;
use App\Http\Services\Message\MessageService;
use Illuminate\Support\Facades\Mail;

// TODO : change to implements if there is error
class EmailService implements MessageInterface
{
    private $details;
    private $subject;
    private array $from = [
        ['address' => null, 'name' => null,]
    ];
    private $to;
    private $files;

    public function fire(): bool
    {

        Mail::to($this->to)->send(new MailViewProvider($this->details, $this->subject, $this->from, $this->files));
        return true;

    }

    public function getDetails()
    {
        return $this->details;
    }

    public function setDetails($details): void
    {
        $this->details = $details;
    }


    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function setFiles($files)
    {
        $this->files = $files;
    }

    public function getFrom(): array
    {
        return $this->from;
    }

    public function setFrom($address, $name): void
    {
        $this->from = [
            [
                'address' => $address,
                'name' => $name,
            ]
        ];
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to): void
    {
        $this->to = $to;
    }


}
