<?php
namespace Laventure\Component\Routing\Resource\Common;

use Laventure\Component\Routing\Collection\Route;
use Laventure\Component\Routing\Router;


/**
 *
*/
abstract class Resource
{

      /**
       * @var array
      */
      protected $routes = [];



      /**
       * Resource name
       *
       * @var string
      */
      protected $name;



      /**
       * Resource controller
       *
       * @var
      */
      protected $controller;




      /**
       * @param string $name
       * @param string $controller
      */
      public function __construct(string $name, string $controller)
      {
           $this->name       = $name;
           $this->controller = $controller;
      }







      /**
       * @param $controller
       * @return void
      */
      public function setController($controller)
      {
           $this->controller = $controller;
      }






      /**
       * @param Router $router
       * @return void
      */
      public function map(Router $router)
      {
           foreach ($this->configureRoutes() as $route) {

               $this->addRoute(
                   $router->map(
                       $route['methods'],
                       $this->routePath($route['path']),
                       $this->routeAction($route['action'])
                   )->name($this->routeName($route['action']))
               );

           }
      }





      /**
       * @param Route $route
       * @return Route
      */
      protected function addRoute(Route $route): Route
      {
           $route->whereNumber($this->routeParameter());

           $this->routes[] = $route;

           return $route;
      }





      /**
       * Get resource name
       *
       * @return string
      */
      public function getName(): string
      {
          return $this->name;
      }



      /**
       * Get resource controller
       *
       * @return string
      */
      public function getController(): string
      {
            return $this->controller;
      }




      /**
       * @return Route[]
      */
      public function getRoutes(): array
      {
          return $this->routes;
      }



      /**
       * @return string
      */
      protected function routeParameter(): string
      {
           // $parameter = strtolower($this->getName());

           // return trim($parameter, 's');

           return 'id';
      }




      /**
       * @param string $path
       * @return string
      */
      protected function routePath(string $path = ''): string
      {
          $path = sprintf('/%s%s', $this->getName(), $path);

          return preg_replace('#parameter#', $this->routeParameter(), $path);
      }



      /**
       * @param string $action
       * @return string
      */
      protected function routeAction(string $action): string
      {
          return $this->getController(). "@$action";
      }





      /**
       * @param string $action
       * @return string
      */
      protected function routeName(string $action): string
      {
           return sprintf('%s.%s', $this->getName(), $action);
      }






     /**
      * @param Router $router
      * @return array
     */
     public function makeRoutes(Router $router): array
     {
            $routes = [];

            foreach ($this->configureRoutes() as $route) {
                $routes[] = $router->makeRoute(
                    $route['methods'],
                    $this->routePath($route['path']),
                    $this->routeAction($route['action'])
                )->name($this->routeName($route['action']))
                    ->whereNumber($this->routeParameter());
            }

            return $routes;
     }




    /**
    * @return array
    */
    abstract protected static function configureRoutes(): array;




    /**
    * Get resource type
    *
    * @return string
    */
    abstract public function getType(): string;
}