<?php
namespace Laventure\Component\Events\Contract;

use Laventure\Component\Events\Event;



/**
 * @class ListenerProviderInterface
 */
interface ListenerProviderInterface
{
    /**
     * @param Event $event
     *   An event for which to return the relevant listeners.
     * @return iterable<callable>
     *   An iterable (array, iterator, or generator) of callables.  Each
     *   callable MUST be type-compatible with $event.
    */
    public function getListenersForEvent(Event $event) : iterable;
}