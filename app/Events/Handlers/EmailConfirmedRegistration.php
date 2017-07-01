<?php


namespace App\Events\Handlers;

use SplObserver;
use SplSubject;
use App\Support\Email\Templates\Welcome;

class EmailConfirmedRegistration implements SplObserver
{

    public function update(SplSubject $event)
    {
        $event->mail->to($event->user->email, $event->user->name)->send(new Welcome($event->user));
    }
}