<?php


namespace App\Events\Handlers;

use SplObserver;
use SplSubject;
use App\Support\Email\Templates\Welcome;
use Swift_SwiftException;

class EmailConfirmedRegistration implements SplObserver
{

    public function update(SplSubject $event)
    {
        try {
            $event->mail->to($event->user->email, $event->user->name)->send(new Welcome($event->user));
        } catch (Swift_SwiftException $e) {
            debug($e);
        }
    }
}