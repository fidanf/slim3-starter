<?php

namespace App\Support\Email;

use App\Support\Email\Contracts\MailableInterface;
use Slim\Views\Twig;
use Swift_Mailer;
use Swift_Message;

class Mailer
{
    protected $swift;

    protected $twig;

    protected $from = [];

    public function __construct(Swift_Mailer $swift, Twig $twig)
    {
        $this->swift = $swift;
        $this->twig = $twig;
    }

    public function to($address, $name = null)
    {
        return (new PendingMailable($this))->to($address, $name);
    }

    public function alwaysFrom($address, $name = null)
    {
        $this->from = compact('address', 'name');

        return $this;
    }

    public function send($view, $viewData = [], Callable $callback = null)
    {
        if ($view instanceof MailableInterface) {
            return $this->sendMailable($view);
        }

        $message = $this->buildMessage();

        call_user_func($callback, $message);

        $message->body($this->parseView($view, $viewData));

        return $this->swift->send($message->getSwiftMessage());
    }

    protected function sendMailable(Mailable $mailable)
    {
        return $mailable->send($this);
    }

    protected function buildMessage()
    {
        return (new MessageBuilder(new Swift_Message))
            ->from($this->from['address'], $this->from['name']);
    }

    protected function parseView($view, $viewData)
    {
        return $this->twig->fetch($view, $viewData);
    }
}
