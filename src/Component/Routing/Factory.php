<?php
namespace Laventure\Component\Routing;


use Closure;
use Laventure\Component\Routing\Collection\Route;
use Laventure\Component\Routing\Group\RouteGroup;
use Laventure\Component\Routing\Resource\ApiResource;
use Laventure\Component\Routing\Resource\Common\Resource;
use Laventure\Component\Routing\Resource\Types\ResourceType;
use Laventure\Component\Routing\Resource\WebResource;


/**
 *
*/
class Factory
{

    /**
     * @param $methods
     * @param $path
     * @param $action
     * @return Route
     */
     public function createRoute($methods, $path, $action): Route
     {
          return new Route($methods, $path, $action);
     }


     /**
      * @return RouteGroup
     */
     public function createRouteGroup(): RouteGroup
     {
          return new RouteGroup();
     }




     /**
      * @param string $name
      * @param string $controller
      * @param string $type
      * @return Resource
     */
     public function createResource(string $name, string $controller, string $type): Resource
     {
            return [
                'web'  => new WebResource($name, $controller),
                'api'  => new ApiResource($name, $controller)
            ][$type];

     }

}