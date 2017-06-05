<?php

namespace App\Support\Email;

class PendingMailable
{
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function to($address, $name = null)
    {
        $this->to = compact('address', 'name');

        return $this;
    }

    public function send(Mailable $mailable)
    {
        $mailable->to($this->to['address'], $this->to['name']);

        return $this->mailer->send($mailable);
    }
}