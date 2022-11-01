<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager\Event;


use Laventure\Component\Database\ORM\Mapper\Manager\Event\Contract\EntityEventManagerInterface;



/**
 * EntityEventManager
*/
class EntityEventManager implements EntityEventManagerInterface
{


       /**
        * @param object $object
        * @param string $eventName
        * @return object
       */
       public function callEvent(object $object, string $eventName): object
       {
             if (method_exists($object, $eventName)) {

                 call_user_func([$object, $eventName]);

                 return $object;
             }

             return $object;
       }




      /**
       * @inheritDoc
      */
      public function preUpdate($object): object
      {
           return $this->callEvent($object, Event::PreUpdate);
      }





      /**
       * @inheritDoc
      */
      public function prePersist($object): object
      {
           return $this->callEvent($object, Event::PrePersist);
      }




     /**
      * @inheritDoc
     */
     public function preRemove($object): object
     {
          return $this->callEvent($object, Event::PreRemove);
     }
}