<?php

namespace App\Events\Handlers;

use SplObserver;
use SplSubject;

class UserNotification implements SplObserver
{
    public function update(SplSubject $event)
    {
        //
    }
}