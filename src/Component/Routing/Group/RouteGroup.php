<?php
namespace Laventure\Component\Routing\Group;


use Closure;



/**
 *
*/
class RouteGroup implements RouteGroupInterface
{

      /**
        * @var Closure
      */
      protected $routes;



      /**
       * @var array
      */
      protected $prefixes = [];



      /**
        * @var array
      */
      protected $modules  = [];




      /**
       * @var array
      */
      protected $names = [];




      /**
       * @var array
      */
      protected $middlewares = [];




      /**
       * @param array $attributes
       * @return $this
      */
      public function attributes(array $attributes): self
      {
          foreach ($attributes as $name => $value) {
              $this->attribute($name, $value);
          }

          return $this;
      }




      /**
       * @param $name
       * @param $value
       * @return $this
      */
      public function attribute($name, $value): self
      {
           if (is_callable([$this, $name])) {
               call_user_func([$this, $name], $value);
           }

           return $this;
      }




      /**
       * @param string $prefix
       * @return $this
      */
      public function prefix(string $prefix): self
      {
           $this->prefixes[] = trim($prefix, '\\/');

           return $this;
      }




      /**
       * @param array $prefixes
       * @return $this
      */
      public function prefixes(array $prefixes): self
      {
           foreach ($prefixes as $prefix) {
               $this->prefix($prefix);
           }

           return $this;
      }




      /**
       * @param string $module
       * @return $this
      */
      public function module(string $module): self
      {
           $this->modules[] = trim($module, '\\');

           return $this;
      }




      /**
       * @param array $modules
       * @return $this
      */
      public function modules(array $modules): self
      {
          foreach ($modules as $module) {
              $this->module($module);
          }

          return $this;
      }



      /**
       * @param string $name
       * @return $this
      */
      public function name(string $name): self
      {
          $this->names[] = $name;

          return $this;
      }




      /**
       * @param array $names
       * @return $this
      */
      public function names(array $names): self
      {
           foreach ($names as $name) {
                $this->name($name);
           }

           return $this;
      }



      /**
       * @param array $middlewares
       * @return $this
      */
      public function middlewares(array $middlewares): self
      {
           $this->middlewares = array_merge($this->middlewares, $middlewares);

           return $this;
      }




      /**
       * @param Closure $routes
       * @return $this
      */
      public function routes(Closure $routes): self
      {
            $this->routes = $routes;

            return $this;
      }



      /**
       * Map routes
       *
       * @param $router
       * @return void
      */
      public function map($router)
      {
           if (is_callable($this->routes)) {
               call_user_func($this->routes, $router);
           }
      }



      /**
       * @return string
      */
      public function getPrefix(): string
      {
          return implode('/', $this->prefixes);
      }



      /**
       * @return string
      */
      public function getModule(): string
      {
          return implode('\\', $this->modules);
      }



      /**
       * @return string
      */
      public function getName(): string
      {
          return implode($this->names);
      }




      /**
       * @return array
      */
      public function getMiddlewares(): array
      {
           return $this->middlewares;
      }



      /**
       * @return array
      */
      public function getAttributes(): array
      {
          return [
              self::PREFIX     => $this->prefixes,
              self::MODULE     => $this->modules,
              self::NAME       => $this->names,
              self::MIDDLEWARE => $this->middlewares
          ];
      }



     /**
      * @return void
     */
     public function refresh()
     {
         $this->prefixes    = [];
         $this->modules     = [];
         $this->names       = [];
         $this->middlewares = [];
     }

}