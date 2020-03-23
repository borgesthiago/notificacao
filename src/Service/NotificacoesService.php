<?php

namespace App\Service;

use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Notifier\Notification\Notification;

class NotificacoesService
{
    private $chatter;
    private $notifier;

    public function __construct(
        ChatterInterface $chatter,
        NotifierInterface $notifier
    )
    {
        $this->chatter = $chatter;
        $this->notifier = $notifier;
    }

    public function getTelegram($parametros)
    {
        $texto = $parametros['mensagem'] . ' Ação: ' . $parametros['acao'] .', Id: '
                .$parametros['id'] .' em ' . $parametros['dataHora'];
        
        $message = (new ChatMessage($texto))
        ->transport('telegram');
        $this->chatter->send($message);

        return;
    }

    public function getSlack($parametros)
    {
        $texto = $parametros['mensagem'] . ' Ação: ' . $parametros['acao'] .' em ' . $parametros['entity'];

        $notification = (new Notification('Nova Notificação'))
        ->content($texto)
        ->importance(Notification::IMPORTANCE_URGENT);

        $this->notifier->send($notification, new Recipient('suporte@jbfsi.com.br'));
        
        return;
    }    
}
