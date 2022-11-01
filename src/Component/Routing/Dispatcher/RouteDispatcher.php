<?php
namespace Laventure\Component\Routing\Dispatcher;

use Laventure\Component\Routing\Collection\Route;

/**
 *
*/
class RouteDispatcher implements RouteDispatcherInterface
{

     /**
      * @param Route $route
      * @return mixed
     */
     public function dispatchRoute(Route $route)
     {
           if (! $route->hasCallback()) {
                $controller = $route->getController();
                $route->callback([new $controller, $route->getAction()]);
           }

           return $route->call();
     }
}