<?php
namespace Laventure\Component\Events\Resolver;

use Laventure\Component\Events\Event;


/**
 * @class EventResolver
 *
 * @package Laventure\Component\Events\Resolver
 *
 * @author Yao Kouassi Jean-Claude <jeanyao@ymail.com>
*/
abstract class EventResolver
{

     /**
      * @param $listener
      * @return mixed
     */
     abstract public function resolveListener($listener);






     /**
      * @param $listener
      * @param Event $event
      * @return mixed
     */
     abstract public function resolveEventDispatch($listener, Event $event);
}