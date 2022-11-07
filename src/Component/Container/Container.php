<?php
namespace Laventure\Component\Container;


use Closure;
use Exception;
use Laventure\Component\Config\Config;
use Laventure\Component\Container\Contract\ContainerAwareInterface;
use Laventure\Component\Container\Contract\ContainerContract;
use Laventure\Component\Container\Contract\ContainerInterface;
use Laventure\Component\Container\Exception\ContainerException;
use Laventure\Component\Container\Facade\Facade;
use Laventure\Component\Container\Provider\Contract\BootableServiceProvider;
use Laventure\Component\Container\Provider\ServiceProvider;
use ReflectionException;
use ReflectionParameter;


/**
 * Container
*/
class Container implements ContainerContract
{


      /**
       * @var self
      */
      protected static $instance;



      /**
       * @var array
      */
      protected $bindings = [];



      /**
       * @var array
      */
      protected $instances = [];



      /**
       * @var array
      */
      protected $aliases = [];



      /**
       * @var array
      */
      protected $resolved = [];




      /**
       * @var array
      */
      protected $providers = [];




      /**
       * @var array
      */
      protected $provides = [];




      /**
       * @var array
      */
      protected $facades = [];



      /**
       * @param ContainerInterface|null $instance
       * @return ContainerInterface|null
      */
      public static function setInstance(ContainerInterface $instance = null): ?ContainerInterface
      {
             return static::$instance = $instance;
      }




      /**
       * @return static
      */
      public static function getInstance(): self
      {
           if (! self::$instance) {
               self::$instance = new static();
           }

           return self::$instance;
      }




      /**
       * @param string $name
       * @return bool
      */
      public function hasProvider(string $name): bool
      {
          return isset($this->providers[$name]);
      }




      /**
       * @param string[] $providers
       * @return void
      */
      public function addProviders(array $providers)
      {
            foreach ($providers as $provider) {
                 $this->addProvider($this->get($provider));
            }
      }




      /**
       * Add Service Provider
       *
       * @param ServiceProvider $provider
       * @return $this
      */
      public function addProvider(ServiceProvider $provider): self
      {
            $provider->setContainer($this);

            if (! $this->hasProvider($name = $provider->getName())) {

                 $this->addProvides($provider->getProvides());

                 $this->bootProvider($provider);

                 $provider->register();

                 $provider->terminate();

                 $this->providers[$name] = $provider;
            }

            return $this;
      }




      /**
       * @return array
      */
      public function getProviders(): array
      {
           return $this->providers;
      }





      /**
       * @param array $provides
       * @return void
      */
      public function addProvides(array $provides)
      {
           foreach ($provides as $abstract => $aliases) {

                 $this->aliases($abstract, $aliases);

                 $this->provides[$abstract] = $aliases;
           }
      }




      /**
       * @return array
      */
      public function getProvides(): array
      {
           return $this->providers;
      }




      /**
       * @param ServiceProvider|BootableServiceProvider $provider
       * @return void
      */
      protected function bootProvider(ServiceProvider $provider)
      {
           $implements = class_implements($provider);

           if(isset($implements[BootableServiceProvider::class])) {
                $provider->boot();
           }
      }




      /**
       * Add Facade
       *
       * @param Facade $facade
       * @return $this
      */
      public function addFacade(Facade $facade): self
      {
            $facade->setContainer($this);

            $this->facades[$facade->getName()] = $facade;

            return $this;
      }





      /**
       * @param string[] $facades
       * @return void
      */
      public function addFacades(array $facades)
      {
          foreach ($facades as $facade) {
              $this->addFacade($this->get($facade));
          }
      }





      /**
       * Get all facades
       *
       * @return Facade[]
      */
      public function getFacades(): array
      {
           return $this->facades;
      }




      /**
       * @return mixed
      */
      public function getBindings()
      {
            return $this->bindings;
      }




      /**
       * @return array
      */
      public function getResolved(): array
      {
           return $this->resolved;
      }




      /**
       * @return array
      */
      public function getAliases(): array
      {
            return $this->aliases;
      }



      /**
       * @param $abstract
       * @return bool
      */
      public function bound($abstract): bool
      {
            return isset($this->bindings[$abstract]);
      }



      /**
       * Bind parameter
       *
       * @param string $abstract
       * @param null $concrete
       * @param bool $shared
       * @return $this
      */
      public function bind(string $abstract, $concrete = null, bool $shared = false): self
      {
            if (is_null($concrete)) {
                 $concrete = $abstract;
            }

            $concrete = $this->resolveConcrete($concrete);

            $this->bindings[$abstract] = compact('concrete', 'shared');

            return $this;
      }





      /**
       * @param array $bindings
       * @return void
      */
      public function binds(array $bindings)
      {
           foreach ($bindings as $abstract => $concrete) {
                $this->bind($abstract, $concrete);
           }
      }





      /**
       * @param string $abstract
       * @param $concrete
       * @return $this
      */
      public function singleton(string $abstract, $concrete): self
      {
           $this->bind($abstract, $concrete, true);

           return $this;
      }




      /**
       * @param array $bindings
       * @return void
      */
      public function singletons(array $bindings)
      {
           foreach ($bindings as $abstract => $concrete) {
                 $this->singleton($abstract, $concrete);
           }
      }





      /**
       * @param string $abstract
       * @param object $instance
       * @return $this
      */
      public function instance(string $abstract, object $instance): self
      {
           $this->instances[$abstract] = $instance;

           return $this;
      }





      /**
       * @param array $instances
       * @return $this
      */
      public function instances(array $instances): self
      {
           foreach ($instances as $name => $concrete) {
                $this->instance($name, $concrete);
           }

           return $this;
      }




      /**
       * @param string $abstract
       * @param string $alias
       * @return $this
      */
      public function alias(string $abstract, string $alias): self
      {
           $this->aliases[$alias] = $abstract;

           return $this;
      }





      /**
       * @param $abstract
       * @return mixed
      */
      public function getAlias($abstract)
      {
           if ($this->hasAlias($abstract)) {
                return $this->aliases[$abstract];
           }

           return $abstract;
      }




       /**
        * @param string $abstract
        * @param array $aliases
        * @return $this
      */
      public function aliases(string $abstract, array $aliases): self
      {
           foreach ($aliases as $alias) {
               $this->alias($abstract, $alias);
           }

           return $this;
      }



      /**
       * Create a new instance with given parameters
       *
       * @param string $abstract
       * @param array $parameters
       * @return mixed
      */
      public function make(string $abstract, array $parameters = [])
      {
            return (function () use ($abstract, $parameters) {
                 return $this->resolve($abstract, $parameters);
            })();
      }




      /**
       * @param string $abstract
       * @return object|null
      */
      public function factory(string $abstract): ?object
      {
            return $this->make($abstract);
      }





      /**
       * @inheritDoc
      */
      public function get($id)
      {
          try {

               return $this->resolve($id);

          } catch (\Exception $e) {

              return (function () use ($e) {
                  throw new ContainerException($e->getMessage());
              })();
          }
      }





      /**
       * @param string $abstract
       * @return mixed
      */
      public function getConcrete(string $abstract)
      {
            if ($this->bound($abstract)) {
                return $this->bindings[$abstract]['concrete'];
            }

            return $abstract;
      }




      /**
       * @param string $abstract
       * @param array $parameters
       * @return mixed
      */
      public function resolve(string $abstract, array $parameters = [])
      {
            $abstract = $this->getAlias($abstract);

            if ($this->instantiable($abstract)) {
                 return $this->makeInstance($abstract, $parameters);
            }

            $concrete = $this->getConcrete($abstract);

            if ($this->shared($abstract)) {
                return $this->share($abstract, $concrete);
            }

            return $concrete;
      }





      /**
       * Determine if can make given parameter.
       *
       * @param $abstract
       * @return bool
      */
      protected function instantiable($abstract): bool
      {
           return ! $this->has($abstract) && $this->existClass($abstract);
      }




      /**
       * @param string $class
       * @param array $with
       * @return mixed
      */
      protected function makeInstance(string $class, array $with = [])
      {
           return (function () use ($class, $with) {

               $reflectionClass = new \ReflectionClass($class);

               if (! $reflectionClass->isInstantiable()) {
                   throw new ReflectionException("Cannot instantiate given argument {$class}");
               }

               $constructor = $reflectionClass->getConstructor();

               if (is_null($constructor)) {
                   return $reflectionClass->newInstance();
               }

               $dependencies = $this->resolveDependencies($constructor->getParameters(), $with);

               return $reflectionClass->newInstanceArgs($dependencies);

           })();
      }




     /**
      * @param string $abstract
      * @param $concrete
      * @return mixed
     */
     protected function share(string $abstract, $concrete)
     {
          if (! $this->hasInstance($abstract)) {
               $this->instances[$abstract] = $concrete;
          }

          return $this->instances[$abstract];
     }



      /**
       * @param string $id
       * @return bool
      */
      public function resolved(string $id): bool
      {
           return isset($this->resolved[$id]);
      }





      /**
       * @param $concrete
       * @return mixed|object|null
      */
      protected function resolveConcrete($concrete)
      {
            if ($concrete instanceof Closure) {
                return $this->callAnonymous($concrete);
            } elseif ($this->existClass($concrete)) {
                return $this->make($concrete);
            }

            return $concrete;
      }




      /**
       * @param $concrete
       * @return bool
      */
      protected function existClass($concrete): bool
      {
           return is_string($concrete) && class_exists($concrete);
      }





      /**
       * @param string $abstract
       * @return bool
      */
      protected function shared(string $abstract): bool
      {
            $shared = isset($this->bindings[$abstract]['shared'])
                      && $this->bindings[$abstract]['shared'] === true;

            return $this->hasInstance($abstract) || $shared;
      }






      /**
       * @param Closure $concrete
       * @param array $params
       * @return mixed
      */
      public function callAnonymous(Closure $concrete, array $params = [])
      {
            return (function () use ($concrete, $params) {

                $reflection = new \ReflectionFunction($concrete);

                $params = $this->resolveDependencies($reflection->getParameters(), $params);

                return call_user_func_array($concrete, $params);

            })();
      }



      /**
       * @param $concrete
       * @param array $params
       * @param string|null $method
       * @return mixed
      */
      public function call($concrete, array $params = [], string $method = null)
      {
            return (function () use ($concrete, $params, $method) {

                if ($concrete instanceof Closure) {
                    return $this->callAnonymous($concrete, $params);
                }

                if (is_string($concrete) && $method) {
                    return $this->callAction($concrete, $method, $params);
                }

                throw new ContainerException("Could not call given parameter type of ". gettype($concrete));

            })();
      }





      /**
       * @param string $concrete
       * @param string $method
       * @param array $params
       * @return mixed
      */
      public function callAction(string $concrete, string $method, array $params = [])
      {
            return (function () use ($concrete, $method, $params) {

                if (! method_exists($concrete, $method)) {
                    throw new ContainerException("Could not call [$concrete, $method].");
                }

                $reflection = new \ReflectionMethod($concrete, $method);
                $arguments = $this->resolveDependencies($reflection->getParameters(), $params);

                $object = $this->get($concrete);

                $implements = class_implements($object);

                if (isset($implements[ContainerAwareInterface::class])) {
                    $object->setContainer($this);
                }

                return call_user_func_array([$object, $method], $arguments);

            })();
      }



      /**
       * @param ReflectionParameter[] $dependencies
       * @param array $with
       * @return array
      */
      public function resolveDependencies(array $dependencies, array $with): array
      {
            $resolved = [];

            foreach ($dependencies as $parameter) {
                  [$name, $value] = $this->resolveDependency($parameter, $with);
                  $this->resolved = array_merge($this->resolved, [$name => $value]);
                  $resolved[]     = $value;
            }

            return $resolved;
      }





      /**
       * @param ReflectionParameter $parameter
       * @param array $with
       * @return array
      */
      protected function resolveDependency(ReflectionParameter $parameter, array $with): array
      {
            $dependency = $parameter->getClass();

            if (! $dependency) {
                return [$parameter->getName(), $this->resolveParameters($parameter, $with)];
            }

            return [$dependency->getName(), $this->get($dependency->getName())];
      }



      /**
       * @param ReflectionParameter $parameter
       * @param array $params
       * @return mixed|void
      */
      protected function resolveParameters(ReflectionParameter $parameter, array $params)
      {
             $name = $parameter->getName();

             if (array_key_exists($name, $params)) {
                  return $params[$name];
             } elseif ($parameter->isDefaultValueAvailable()) {
                 return $parameter->getDefaultValue();
             } elseif ($this->hasInstance($name)) {
                  return $name;
             }

             $this->unresolvableDependencyException($parameter);
      }



      /**
       * @param ReflectionParameter $parameter
       * @return mixed
      */
      protected function unresolvableDependencyException(ReflectionParameter $parameter)
      {
           $message = "Unresolvable dependency [{$parameter}] in class {$parameter->getDeclaringClass()->getName()}";

           throw new \InvalidArgumentException($message);
      }




      /**
       * @inheritDoc
      */
      public function has($id): bool
      {
            return $this->bound($id) || $this->hasInstance($id) || $this->hasAlias($id);
      }




      /**
       * @param $id
       * @return bool
      */
      public function hasInstance($id): bool
      {
           return isset($this->instances[$id]);
      }




      /**
       * @param $id
       * @return bool
      */
      public function hasAlias($id): bool
      {
           return isset($this->aliases[$id]);
      }





      /**
       * @param $id
       * @return void
      */
      public function remove($id)
      {
          unset(
              $this->bindings[$id],
              $this->aliases[$id],
              $this->resolved[$id],
              $this->instances[$id]
          );
      }



     /**
      * @param mixed $id
      * @return bool
     */
     public function offsetExists($id): bool
     {
         return $this->has($id);
     }





    /**
     * @param mixed $id
     * @return mixed
     * @throws Exception
    */
    public function offsetGet($id)
    {
        return $this->get($id);
    }





    /**
     * @param mixed $id
     * @param mixed $value
    */
    public function offsetSet($id, $value)
    {
        $this->bind($id, $value);
    }





    /**
     * @param mixed $id
    */
    public function offsetUnset($id)
    {
         $this->remove($id);
    }





    /**
     * @param $name
     * @return array|bool|mixed|object|string|null
     */
    public function __get($name)
    {
        return $this[$name];
    }




    /**
     * @param $name
     * @param $value
    */
    public function __set($name, $value)
    {
        $this[$name] = $value;
    }




    /**
     * @return void
    */
    public function purge()
    {
        $this->bindings  = [];
        $this->instances = [];
        $this->aliases   = [];
        $this->resolved  = [];
    }

}