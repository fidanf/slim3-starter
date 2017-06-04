<?php

namespace App\Events;

use App\Models\User;

class UserEvent extends Event
{
    public $user;

    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }
}