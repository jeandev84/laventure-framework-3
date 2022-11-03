<?php
namespace Laventure\Component\Events\Dispatcher;


use Laventure\Component\Events\Contract\EventDispatcherInterface;
use Laventure\Component\Events\Event;
use Laventure\Component\Events\Listener\EventListener;


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
}