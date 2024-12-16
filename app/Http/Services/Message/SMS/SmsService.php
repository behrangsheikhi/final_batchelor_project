<?php

namespace App\Http\Services\Message\SMS;

use App\Http\Interfaces\MessageInterface;

class SmsService implements MessageInterface
{

    private $from;
    private $text;
    private $to;
    private bool $is_flash = true;
    private $bodyId;

    /**
     */
    public function fire(): ?bool
    {
        $meliPayamak = new MeliPayamakService();
        return $meliPayamak->SendByBaseNumber($this->text, $this->to, $this->bodyId);
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setFrom($from): void
    {
        $this->from = $from;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text): void
    {
        $this->text = $text;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to): void
    {
        $this->to = $to;
    }

    public function setIsFlash($isFlash): void
    {
        $this->is_flash = $isFlash;
    }

    public function getIsFlash(): bool
    {
        return $this->is_flash;
    }

}
