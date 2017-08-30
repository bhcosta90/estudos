<?php

namespace app\events;

use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class Data implements EventSubscriber {

    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preUpdate,
        );
    }

    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if (method_exists($entity, 'setCreatedAt')) {
            $entity->setCreatedAt(TEMPO);
        }
    }

    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if (method_exists($entity, 'setUpdateAt')) {
            if($entity->getRemoveAt()==""){
                $entity->setUpdateAt(TEMPO);
            }
        }
    }


}

?>
