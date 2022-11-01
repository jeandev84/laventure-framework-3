<?php
declare(strict_types=1);

namespace Laventure\Component\Routing\Collection;


use Laventure\Component\Routing\Collection\Exception\BadActionException;
use Laventure\Component\Routing\Collection\Exception\BadControllerException;

/**
 * Route class
 *
 * @package Laventure\Component\Routing\Collection
*/
class Route implements \ArrayAccess
{


       /**
        * Route domain
        *
        * @var  string
       */
       protected $domain;



       /**
        * Route path
        * 
        * @var string
       */
       protected $path;




       /**
        * Route callback handle.
        *
        * @var callable
       */
       protected $callback;



       /**
        * Route name
        *
        * @var string
       */
       protected $name;



       /**
         * Route action
         *
         * this property store controller class name and action to call
         *
         * @var mixed
       */
       protected $action = [
            'controller' => '',
            'action'     => ''
       ];



       /**
        * Route methods
        *
        * @var array
       */
       protected $methods = ['GET'];



       /**
        * Route patterns (regular expression)
        *
        * @var array
       */
       protected $wheres = [];




       /**
        * Route matches params
        *
        * @var array
       */
       protected $matches = [];





       /**
        * Route middlewares
        *
        * @var array
       */
       protected $middlewares = [];



       /**
        * Route options
        *
        * @var array
       */
       protected $options = [];


       /**
        * Route constructor
        *
        * @param array $methods
        * @param string|null $path
        * @param mixed $action
       */
       public function __construct(array $methods = [], string $path = null, $action = null)
       {
            $this->methods($methods);
            $this->path($path);
            $this->action($action);
       }




       /**
         * Set route domain
         *
         * @param $domain
         * @return $this
       */
       public function domain($domain): self
       {
            $this->domain = $domain;

            return $this;
        }




       /**
        * Set route methods
        *
        * @param array $methods
        * @return $this
       */
       public function methods(array $methods): self
       {
            $this->methods = $methods;

            return $this;
       }



       /**
        * Set route path
        *
        * @param string $path
        * @return $this
       */
       public function path(string $path): self
       {
            $this->path = $path;

            return $this;
       }




       /**
        * Set method action
        *
        * @param $action
        * @return $this
       */
       public function action($action): self
       {
           if (is_array($action)) {
                $this->controller($action);
           }elseif (is_callable($action)) {
                $this->callback($action);
           }

           return $this;
       }




       /**
         * Set route controller and action
         *
         * @param array $params
         * @return $this
       */
       public function controller(array $params): self
       {
           $params = array_values($params);

           if (count($params) == 2) {
               list($controller, $action) = $params;
               $this->action = compact('controller', 'action');
           }

           return $this;
       }



       /**
        * @param $name
        * @return $this
       */
       public function name($name): self
       {
            $this->name .= $name;

            return $this;
       }



       /**
        * Set route callback
        *
        * @param callable $callback
        * @return $this
       */
       public function callback(callable $callback): self
       {
           $this->callback = $callback;

           return $this;
       }





       /**
        * @return array
       */
       protected function getMiddlewareStack(): ?array
       {
           return $this->getOption('middlewareStack', []);
       }


       /**
         * Set route middlewares
         *
         * @param $middlewares
         * @return $this
       */
       public function middleware($middlewares): self
       {
           $this->middlewares = array_merge($this->middlewares, (array) $middlewares);

           return $this;
       }




       /**
        * @return mixed
       */
       public function call()
       {
            return call_user_func_array($this->callback, $this->matches);
       }




       /**
        * Set route options params
        *
        * @param array $options
        * @return $this
       */
       public function withOptions(array $options): self
       {
            $this->options = array_merge($this->options, $options);

            return $this;
       }




       /**
        * Set a route option
        *
        * @param string $name
        * @param $value
        * @return $this
       */
       public function withOption(string $name, $value): self
       {
            return $this->withOptions([$name => $value]);
       }





       /**
         * Set route patterns
         *
         * @param $name
         * @param mixed $regex
         * @return $this
       */
       public function where($name, $regex = null): self
       {
            foreach ($this->parseWhere($name, $regex) as $name => $regex) {
                $this->wheres[$name] = $this->resolveRegexp($name, $regex);
            }

            return $this;
       }





       /**
         * @param string $name
         * @return $this
       */
       public function whereNumber(string $name): self
       {
            return $this->where($name, '\d+');
       }




        /**
         * @param string $name
         * @return $this
        */
        public function whereText(string $name): self
        {
              return $this->where($name, '\w+');
        }




        /**
         * @param string $name
         * @return $this
        */
        public function whereAlphaNumeric(string $name): self
        {
            return $this->where($name, '[^a-z_\-0-9]'); // [^a-z_\-0-9]
        }





        /**
         * @param string $name
         * @return $this
        */
        public function whereSlug(string $name): self
        {
             return $this->where($name, '[a-z\-0-9]+');
        }




        /**
         * @param string $name
         * @return $this
        */
        public function anything(string $name): self
        {
             return $this->where($name, '.*');
        }





        /**
         * Determine if the given request method and path matches.
         *
         * @param string $method
         * @param string $path
         * @return boolean
       */
       public function match(string $method, string $path): bool
       {
            return $this->matchRequestMethod($method) && $this->matchRequestPath($path);
       }




       /**
        * Return route methods
        *
        * @return array
       */
       public function getMethods(): array
       {
           return $this->methods;
       }




       /**
        * @param string $separator
        * @return string
       */
       public function getMethodsToString(string $separator = '|'): string
       {
            return implode($separator, $this->getMethods());
       }




       /**
        * @return string
       */
       public function getPath(): string
       {
           return $this->path ?? '/';
       }




       /**
        * @return string|null
       */
       public function getName(): ?string
       {
            return $this->name;
       }




       /**
        * Return route domain
        *
        * @return string
       */
       public function getDomain(): string
       {
            return $this->domain;
       }




       /**
        * Get route pattern
        *
        * @return string
       */
       public function getPattern(): string
       {
            $pattern = $this->getPath();

            if ($this->wheres) {
                $pattern = $this->replacePlaceholders($pattern, $this->wheres);
            }

            return '#^'. $this->resolvePath($pattern) . '$#i';
       }





       /**
        * Get route middlewares
        *
        * @return array
       */
       public function getMiddlewares(): array
       {
           return $this->middlewares;
       }



       /**
        * Get route patterns
        *
        * @return array
       */
       public function getWheres(): array
       {
           return $this->wheres;
       }




       /**
        * Get route options
        *
        * @return array
       */
       public function getOptions(): array
       {
            return $this->options;
       }



       /**
        * Get Option
        *
        * @param string $name
        * @param $default
        * @return mixed|null
      */
       public function getOption(string $name, $default = null)
       {
           return $this->options[$name] ?? $default;
       }




       /**
        * Get controller name
        *
        * @return string
       */
       public function getControllerName(): string
       {
           return $this->action["controller"];
       }




       /**
        * Get action name
        *
        * @return string
       */
       public function getActionName(): string
       {
           return $this->action['action'];
       }




       /**
        * @return string
        * @throws BadControllerException
       */
       public function getController(): string
       {
           $controller = $this->getControllerName();

           if (! $this->existController()) {
               throw new BadControllerException($controller);
           }

           return $controller;
       }



       /**
        * @return string
        * @throws BadActionException
        * @throws BadControllerException
       */
       public function getAction(): string
       {
            $action = $this->getActionName();

            if (! $this->callableAction()) {
                 throw new BadActionException($this->getController(), $action);
            }

            return $action;
       }



       /**
        * @return bool
       */
       public function hasClosure(): bool
       {
            return $this->getCallback() instanceof \Closure;
       }




       /**
        * @return string
       */
       public function getTarget(): string
       {
           if ($this->hasClosure()) {
                return "Closure";
           }

           return sprintf('%s@%s',
              $this->getControllerName(),
              $this->getActionName()
           );
       }


       /**
        * @return callable
       */
       public function getCallback(): ?callable
       {
            return $this->callback;
       }




       /**
        * Determine if the given request path match route path.
        *
        * @param string $requestPath
        * @return bool
       */
       public function matchRequestPath(string $requestPath): bool
       {
             $pattern = $this->getPattern();

             if (preg_match($pattern, $this->resolveRequestPath($requestPath), $matches)) {

                 $this->matches = $this->filteredParameters($matches);

                 $this->withOptions(compact('pattern', 'requestPath'));

                 return true;
             }

             return false;
       }




       /**
        * Get matches parameters
        *
        * @return array
       */
       public function getMatches(): array
       {
            return $this->matches;
       }




       /**
         * Get matches values
         *
         * @return array
       */
       public function getMatchValues(): array
       {
            return array_values($this->getMatches());
       }





      /**
       * Convert path parameters
       *
       * @param array $params
       * @return string
      */
      public function generatePath(array $params): string
      {
          $path = $this->getPath();

          foreach ($params as $k => $v) {
             $path = preg_replace(["#{{$k}}#", "#{{$k}.?}#"], [$v, $v], $path);
          }

          return $this->resolvePath($path);
     }




       /**
        * Determine if the given request method in route methods.
        *
        * @param string $requestMethod
        * @return bool
       */
       public function matchRequestMethod(string $requestMethod): bool
       {
             if (in_array($requestMethod, $this->methods)) {

                 $this->withOptions(compact('requestMethod'));

                 return true;
             }

             return false;
       }




       /**
        * @param array $matches
        * @return array
       */
       protected function filteredParameters(array $matches): array
       {
            return array_filter($matches, function ($key) {

                return ! is_numeric($key);

            }, ARRAY_FILTER_USE_KEY);
       }


      /**
       * @return bool
       * @throws BadControllerException
      */
      public function callableAction(): bool
      {
           return method_exists($this->getController(), $this->getActionName());
      }




      /**
       * @return bool
      */
      public function existController(): bool
      {
           return class_exists($this->action['controller']);
      }




      /**
       * Determine if callback exist.
       *
       * @return bool
      */
      public function hasCallback(): bool
      {
          return is_callable($this->callback);
      }



      /**
       * prepare path
       *
       * @param $path
       * @return string
      */
      protected function resolvePath($path): string
      {
           return sprintf('/%s', $this->removeSlashes($path));
      }



      /**
       * remove trailing slashes
       *
       * @param $path
       * @return string
      */
      protected function removeSlashes($path): string
      {
           return trim($path, '\\/');
      }



      /**
       * resolve request path
       *
       * @param $path
       * @return string
      */
      protected function resolveRequestPath($path): string
      {
          return $this->resolvePath(parse_url($path, PHP_URL_PATH));
      }




      /**
       * @param string $path
       * @param array $patterns
       * @return array|string|string[]|null
      */
      protected function replacePlaceholders(string $path, array $patterns)
      {
          foreach ($patterns as $k => $v) {
              $path = preg_replace(["#{{$k}}#", "#{{$k}.?}#"], [$v, '?'. $v .'?'], $path);
          }

          return $path;
      }



      /**
       * @param $name
       * @param $regex
       * @return array
      */
      protected function parseWhere($name, $regex): array
      {
          return \is_array($name) ? $name : [$name => $regex];
      }



      /**
       * @param $name
       * @param $regex
       * @return string
      */
      protected function resolveRegexp($name, $regex): string
      {
          $regex = str_replace('(', '(?:', $regex);

          return sprintf('(?P<%s>%s)', $name, $regex);
      }



     /**
      * @param mixed $offset
      * @return bool
     */
     public function offsetExists($offset): bool
     {
         return property_exists($this, $offset);
     }



     /**
      * @param mixed $offset
      * @return mixed|void
     */
     public function offsetGet($offset)
     {
         if(property_exists($this, $offset)) {
             return $this->{$offset};
         }

         return null;
     }




    /**
     * @param mixed $offset
     * @param mixed $value
    */
    public function offsetSet($offset, $value)
    {
        if(property_exists($this, $offset)) {
            $this->{$offset} = $value;
        }
    }



    /**
     * @param mixed $offset
    */
    public function offsetUnset($offset)
    {
        if(property_exists($this, $offset)) {
            unset($this->{$offset});
        }
    }


}