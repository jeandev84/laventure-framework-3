<?php
namespace Laventure\Component\Event;


/**
 * Event
*/
abstract class Event
{

      /**
       * Return event name
       *
       * @return string
      */
      public function getName(): string
      {
           return (new \ReflectionClass(get_called_class()))->getShortName();
      }
}