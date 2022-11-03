<?php
namespace Laventure\Component\Events;


/**
 * Event
*/
abstract class Event
{


       /**
        * @var string
       */
       protected $name;




      /**
       * Return event name
       *
       * @return string
      */
      public function getName(): string
      {
           return $this->name ?? (new \ReflectionClass(get_called_class()))->getShortName();
      }
}