<?php
namespace Laventure\Component\Events\Contract;


use Laventure\Component\Events\Event;


/**
 * @class EventDispatcherInterface
*/
interface EventDispatcherInterface
{
    /**
     * Provide all relevant listeners with an event to process.
     *
     * @param Event $event
     *   The object to process.
     *
     * @return object
     *   The Event that was passed, now modified by listeners.
    */
    public function dispatch(Event $event): object;
}