<?php

namespace App\Events\Handlers;

use SplObserver;
use SplSubject;

class CreateUserRecord implements SplObserver
{
    public function update(SplSubject $event)
    {
        $event->user->save();
    }
}