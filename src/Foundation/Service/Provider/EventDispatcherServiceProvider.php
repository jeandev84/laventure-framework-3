<?php
namespace Laventure\Foundation\Service\Provider;

use Laventure\Component\Container\Provider\ServiceProvider;
use Laventure\Component\Events\Contract\EventDispatcherInterface;
use Laventure\Component\Events\Dispatcher\EventDispatcher;
use Laventure\Component\Events\Event;



/**
 * @class  EventDispatcherServiceProvider
 *
 * @package Laventure\Foundation\Service\Provider
*/
class EventDispatcherServiceProvider extends ServiceProvider
{

    /**
     * @var \string[]
    */
    protected $provides = [
        EventDispatcher::class => ['events', EventDispatcherInterface::class]
    ];




    /**
     * @inheritDoc
    */
    public function register()
    {
        /*
        $this->app->singleton(EventDispatcher::class, function () {
             return $this->app->make(EventDispatcher::class, [
                 'events' => $this->getEvents()
             ]);
        });
        */
    }





    /**
     * @return Event[]
    */
    private function getEvents(): array
    {
         $files = fs()->collection('/app/Events/*')->names();

         $events = [];

         foreach ($files as $file) {
            $event = $this->app->get($this->loadEventFile($file));
            if ($event instanceof Event) {
                $events[] = $event;
            }
         }

         return $events;
    }




    /**
     * @param $file
     * @return string
    */
    private function loadEventFile($file): string
    {
         return sprintf('%s\\%s', config()->get('namespaces.events'),$file);
    }
}