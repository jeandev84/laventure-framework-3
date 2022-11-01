<?php
namespace Laventure\Component\Event\Listener;


use Laventure\Component\Event\Contract\EventListenerInterface;
use Laventure\Component\Event\Dispatcher\EventDispatcherContract;
use Laventure\Component\Event\Event;


/**
 * @EventListener
 */
abstract class EventListener implements EventListenerInterface
{

    /**
     * @var EventDispatcherContract
     */
    protected $dispatcher;



    /**
     * @param \Laventure\Component\Event\Dispatcher\EventDispatcherContract $dispatcher
     * @return void
     */
    public function setDispatcher(EventDispatcherContract $dispatcher)
    {
         $this->dispatcher = $dispatcher;
    }



    /**
     * @param Event $event
     * @return iterable
     */
    public function getListenersForEvent(Event $event): iterable
    {
        return $this->dispatcher->getListenersByEvent($event);
    }




    /** @param Event $event */
    abstract public function handle(Event $event);
}