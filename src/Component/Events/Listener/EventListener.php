<?php
namespace Laventure\Component\Events\Listener;


use Laventure\Component\Events\Contract\EventListenerInterface;
use Laventure\Component\Events\Dispatcher\EventDispatcherContract;
use Laventure\Component\Events\Event;


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
     * @param EventDispatcherContract $dispatcher
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