<?php

namespace AppBundle\Service;

class Messenger
{
    private $mailer;
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer=$mailer;
    }

    public function sendMessage($text)
    {
        $message = (new \Swift_Message('Hello!'))
            ->setFrom('khmelinina34@gmail.com')
            ->setTo('sabaka.and@mail.ru')
            ->addPart($text);
        dump($this->mailer->send($message));die();
    }
}