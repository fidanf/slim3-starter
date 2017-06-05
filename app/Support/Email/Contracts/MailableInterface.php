<?php

namespace App\Support\Email\Contracts;

use App\Support\Email\Mailer;

interface MailableInterface
{
    public function send(Mailer $mailer);
}
