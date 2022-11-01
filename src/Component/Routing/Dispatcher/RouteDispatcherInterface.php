<?php
namespace Laventure\Component\Routing\Dispatcher;


use Laventure\Component\Routing\Collection\Route;


/**
 *
*/
interface RouteDispatcherInterface
{
      /**
       * Dispatch route
       *
       * @param Route $route
       * @return mixed
      */
      public function dispatchRoute(Route $route);
}