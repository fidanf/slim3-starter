<?php

namespace App\Events;

use App\Models\User;
use App\Support\Email\Mailer;

class UserRegisterEvent extends Event
{
    public $user;
    public $mail;

    public function __construct(User $user, Mailer $mail)
    {
        parent::__construct();
        $this->user = $user;
        $this->mail = $mail;
    }
}