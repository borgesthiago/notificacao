<?php

namespace App\EventListener;

use DateTime;
use App\Service\NotificacoesService;
use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

class DatabaseActivitySubscriber implements EventSubscriber
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

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postRemove,
            Events::postUpdate,
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->logActivity('persist', $args);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->logActivity('remove', $args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->logActivity('update', $args);
    }

    private function logActivity(string $action, LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $date = new DateTime('now');
        
        $parametros = [
            'id' => $entity->getId(),
            'acao' => $action,
            'mensagem' => 'Mensagem automática, não responder por favor!',
            'dataHora' => $date->format('d/m/Y H:i:s')
        ];
        $notificacao = new NotificacoesService();

        $notificacao->getTelegram($this->chatter, $parametros);
        $notificacao->getSlack($this->notifier, $parametros);
    }
}
