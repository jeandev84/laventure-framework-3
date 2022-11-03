<?php
namespace Laventure\Foundation\Event;

use Laventure\Component\Events\Contract\EventDispatcherInterface;
use Laventure\Component\Events\Dispatcher\EventDispatcher;
use Laventure\Component\Events\Event;
use Laventure\Component\Events\Listener\EventListener;
use Laventure\Foundation\Application;
use Laventure\Foundation\Event\Dispatcher\AbstractEventDispatcher;


/**
 * @inheritdoc
*/
class Dispatcher extends EventDispatcher
{


         /**
          * @var Application
         */
         protected $app;





         /**
          * @var Event[]
         */
         protected $events = [];




         /**
          * @var array
         */
         protected $dispatched = [];





         /**
          * Dispatcher constructor.
          *
          * @param Application $app
          * @param array $events
         */
         public function __construct(Application $app, array $events)
         {
               $this->app    = $app;
               $this->events = $events;
         }






        /**
         * Add event listener
         *
         * @param EventListener|callable $listener
         * @return $this
        */
        public function addListener($eventName, $listener): self
        {
            if ($listener instanceof EventListener) {
                 $listener->setDispatcher($this);
            }

            $this->listeners[$eventName][] = $listener;

            return $this;
        }





        /**
          * Dispatch one or more events.
          *
          *
          * @param Event|null $event
          * @return void
        */
        public function dispatch(Event $event = null)
        {
                if ($event) {
                    $this->callEvent($event);
                } else {
                    foreach ($this->events as $event) {
                        $this->callEvent($event);
                    }
                }
        }







        /**
         * @param Event $event
         * @return void
        */
        private function callEvent(Event $event)
        {
             $listeners = $this->getListenersByEvent($event->getName());

             if (! isset($this->dispatched[$event->getName()])) {

                 foreach ($listeners as $listener) {
                     if ($listener instanceof EventListener) {
                         $listener->handle($event);
                     } elseif (is_callable($listener)){
                         $this->app->call($listener, [$event]);
                     }
                     $this->dispatched[$event->getName()] = $event;
                 }
             }
        }
}