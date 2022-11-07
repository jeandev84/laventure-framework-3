<?php
namespace Laventure\Component\Events\Dispatcher;

use Laventure\Component\Events\Event;
use Laventure\Component\Events\Listener\EventListener;



/**
 * @class EventDispatcher
 *
 * @package Laventure\Component\Events\Dispatcher
 *
 * @author Yao Kouassi Jean-Claude <jeanyao@ymail.com>
*/
class EventDispatcher extends EventDispatcherContract
{


    /**
     * @var EventListener[]
    */
    protected $listeners = [];





    /**
     * @var Event[]
    */
    protected $events = [];





    /**
     * @var array
    */
    protected $dispatched = [];





    /**
     * Add Listeners
     *
     * @param $eventName
     * @param EventListener $listener
    */
    public function addListener($eventName, EventListener $listener)
    {
         $listener->setDispatcher($this);

         $this->listeners[$eventName][] = $listener;
    }




    /**
     * @inheritDoc
    */
    public function dispatchEvent(Event $event)
    {
        foreach ($this->getListenersByEvent($event->getName()) as $listener) {
             $listener->handle($event);
        }
    }
}