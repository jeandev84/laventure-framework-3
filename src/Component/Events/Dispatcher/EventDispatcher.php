<?php
namespace Laventure\Component\Events\Dispatcher;

use Laventure\Component\Events\Event;
use Laventure\Component\Events\Listener\EventListener;



/**
 * @class EventDispatcher
 *
 * @package Laventure\Component\Events\Dispatcher
 *
 * @author Yao Kouassi Jean-Claude <jeanyao@ymail.com php>
*/
class EventDispatcher extends EventDispatcherContract
{


    /**
     * @var EventListener[]
    */
    protected $listeners = [];




    /**
     * Add Listeners
     *
     * @param $eventName
     * @param EventListener $listener
     * @return mixed
    */
    public function addListener($eventName, EventListener $listener)
    {
         $listener->setDispatcher($this);

         $this->listeners[$eventName][] = $listener;

         return $this;
    }






    /**
     * @inheritDoc
    */
    public function dispatch(Event $event)
    {
        foreach ($this->getListenersByEvent($event->getName()) as $listener) {
             $listener->handle($event);
        }
    }
}