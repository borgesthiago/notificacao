<?php

namespace App\EventListener;

use DateTime;
use App\Service\NotificacoesService;
use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Notification\Notification;

class DatabaseActivitySubscriber implements EventSubscriber
{

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
        $parametros = [
            'id' => $entity->getId(),
            'acao' => $action,
            'mensagem' => 'Mensagem automática, não responder por favor!',
            'dataHora' => new DateTime('NOW')
        ];
        $telegram = new NotificacoesService(new ChatterInterface $a,new NotifierInterface $b);
        $telegram->getTelegram($parametros);
    }
}
