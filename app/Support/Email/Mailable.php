<?php

namespace App\Support\Email;

use App\Support\Email\Contracts\MailableInterface;

abstract class Mailable implements MailableInterface
{
    protected $to = [];

    protected $from = [];

    protected $subject;

    protected $view;

    protected $attachments = [];

    protected $viewData = [];

    public function send(Mailer $mailer)
    {
        $this->build();

        $mailer->send($this->view, $this->viewData, function ($message) {
            $message->to($this->to['address'], $this->to['name'])
                ->subject($this->subject);

            if ($this->from) {
                $message->from($this->from['address'], $this->from['name']);
            }

            $this->buildAttachments($message);
        });
    }

    public function to($address, $name = null)
    {
        $this->to = compact('address', 'name');

        return $this;
    }

    public function from($address, $name = null)
    {
        $this->from = compact('address', 'name');

        return $this;
    }

    public function view($view)
    {
        $this->view = $view;

        return $this;
    }

    public function with($viewData = [])
    {
        $this->viewData = $viewData;

        return $this;
    }

    public function attach($file)
    {
        $this->attachments[] = $file;

        return $this;
    }

    public function subject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    protected function buildAttachments(MessageBuilder $message)
    {
        foreach ($this->attachments as $file) {
            $message->attach($file);
        }
    }
}