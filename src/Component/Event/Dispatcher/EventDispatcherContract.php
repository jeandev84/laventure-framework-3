<?php
namespace Laventure\Component\Event\Dispatcher;


use Laventure\Component\Event\Contract\EventDispatcherInterface;
use Laventure\Component\Event\Event;
use Laventure\Component\Event\Listener\EventListener;


/**
 * @class EventDispatcherContract
*/
abstract class EventDispatcherContract implements EventDispatcherInterface
{

    /**
     * @var mixed
     */
    protected $listeners = [];




    /**
     * @return EventListener[]
     */
    public function getListeners(): array
    {
        return $this->listeners;
    }



    /**
     * Get listeners by event name
     * @param $eventName
     * @return EventListener[]
     */
    public function getListenersByEvent($eventName): array
    {
        if(! $this->hasListeners($eventName)) {
            return [];
        }

        return $this->listeners[$eventName];
    }



    /**
     * @param string $eventName
     * @return bool
     */
    public function hasListeners(string $eventName): bool
    {
        return isset($this->listeners[$eventName]);
    }



    /**
     * @param Event $event
     * @return void
     */
    abstract public function dispatch(Event $event);
}