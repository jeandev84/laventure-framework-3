<?php
namespace Laventure\Foundation\Event;


use Laventure\Component\Events\Dispatcher\EventDispatcher as AbstractEventDispatcher;
use Laventure\Component\Events\Event;
use Laventure\Component\Events\Listener\EventListener;
use Laventure\Foundation\Application;


/**
 * @inheritdoc
*/
class EventDispatcher extends AbstractEventDispatcher
{


         /**
          * @var Application
         */
         protected $app;





         /**
          * @var array
         */
         protected $dispatched = [];





         /**
          * Dispatcher constructor.
          *
          * @param Application $app
         */
         public function __construct(Application $app)
         {
               $this->app = $app;
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
                    $this->dispatchEvent($event);
                } else {
                    $eventName = '';
                }
        }







        /**
         * @param Event $event
         * @return void
        */
        public function dispatchEvent(Event $event)
        {
             // todo refactoring
             $listeners = $this->getListenersByEvent($event->getName());

             if (! $this->dispatched($event->getName())) {

                 foreach ($listeners as $listener) {
                     if ($listener instanceof EventListener) {
                         $listener->handle($event);
                     }elseif(is_callable($listener)){
                         $this->app->call($listener, [$event]);
                     }
                     $this->dispatched[$event->getName()] = $event;
                 }
             }
        }






        /**
         * @param $name
         * @return bool
        */
        public function dispatched($name): bool
        {
             return isset($this->dispatched[$name]);
        }
}