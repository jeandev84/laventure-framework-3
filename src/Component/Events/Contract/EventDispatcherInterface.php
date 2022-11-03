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
     * @return mixed
     *   The Event that was passed, now modified by listeners.
     *    May be to return object or null
    */
    public function dispatchEvent(Event $event);
}