<?php
namespace Laventure\Component\Routing\Collection;




/**
 * RouteCollection class
 *
 * @package Laventure\Component\Routing\Collection
*/
class RouteCollection
{

         /**
          * Collect routes
          *
          * @var Route[]
         */
         protected $routes = [];




         /**
          * Collect routes by name
          *
          * @var array
         */
         protected $names = [];




        /**
         * Collect routes by method.
         *
         * @var array
        */
        protected $methods = [];




        /**
          * Collect route by controller.
          *
          * @var array
        */
        protected $controllers = [];




        /**
         * RouteCollection constructor.
         *
         * @param Route[] $routes
        */
        public function __construct(array $routes = [])
        {
              if ($routes) {
                  $this->addRoutes($routes);
              }
        }



        /**
         * Add route
         *
         * @param Route $route
         * @return Route
       */
       public function addRoute(Route $route): Route
       {
            $this->collect($route);

            return $route;
       }



       /**
        * @param Route $route
        * @return void
       */
       public function removeRoute(Route $route)
       {
           $key     = array_search($route, $this->routes);
           $methods = $route->getMethodsToString();

           if ($controller = $route->getControllerName()) {
               unset($this->controllers[$controller]);
           }

           if ($name = $route->getName()) {
               unset($this->names[$name]);
           }

           unset($this->methods[$methods][$route->getPath()]);
           unset($this->routes[$key]);
       }




       /**
        * @param string $name
        * @return void
       */
       public function removeRouteByName(string $name)
       {
            if ($this->hasName($name)) {
                $this->removeRoute($this->getRoute($name));
            }
       }



       /**
        * @param string $name
        * @param Route $route
        * @return Route
       */
       public function add(string $name, Route $route): Route
       {
            $route->name($name);

            return $this->addRoute($route);
       }




      /**
       * @return void
      */
      public function refreshNames()
      {
          foreach ($this->routes as $route) {
              if ($name = $route->getName()) {
                  $this->names[$name] = $route;
              }
          }
      }




       /**
        * Add routes
        *
        * @param Route[] $routes
        * @return void
       */
       public function addRoutes(array $routes)
       {
            foreach ($routes as $route) {
                $this->addRoute($route);
            }
       }




       /**
        * @param string $name
        * @return bool
       */
       public function hasName(string $name): bool
       {
            return array_key_exists($name, $this->getNames());
       }




       /**
        * @param string $name
        * @return bool
       */
       public function hasMethod(string $name): bool
       {
            return array_key_exists($name, $this->methods);
       }




       /**
        * @param string $name
        * @return bool
       */
       public function hasController(string $name): bool
       {
            return array_key_exists($name, $this->controllers);
       }




       /**
        * @return Route[]
       */
       public function getRoutes(): array
       {
            return $this->routes;
       }




       /**
        * Get route by given name
        *
        * @param string $name
        * @return Route
       */
       public function getRoute(string $name): Route
       {
           return $this->getNames()[$name];
       }




       /**
        * Get route names
        *
        * @return array
       */
       public function getNames(): array
       {
           $this->refreshNames();

           return $this->names;
       }




       /**
        * @param string $name
        * @return Route[]
       */
       public function getRoutesByMethod(string $name): array
       {
           return $this->methods[$name] ?? [];
       }




       /**
        * @return array
       */
       public function getMethods(): array
       {
           return $this->methods;
       }




       /**
        * @param string $name
        * @return Route[]
       */
       public function getRoutesByController(string $name): array
       {
            return $this->controllers[$name] ?? [];
       }



       /**
        * @return array
       */
       public function getControllers(): array
       {
           return $this->controllers;
       }



       /**
        * Generate URI
        *
        * @param string $name
        * @param array $parameters
        * @return string|null
       */
       public function generate(string $name, array $parameters = []): ?string
       {
            if (! $this->hasName($name)) {
                return null;
            }

            return $this->getRoute($name)->generatePath($parameters);
       }



       /**
        * @param Route $route
        * @return $this
       */
       public function collect(Route $route): self
       {
             $methods = $route->getMethodsToString();

             $this->methods[$methods][$route->getPath()] = $route;

             if ($controller = $route->getControllerName()) {
                 $this->controllers[$controller][$route->getPath()] = $route;
             }

             $this->routes[] = $route;

             return $this;
       }
}