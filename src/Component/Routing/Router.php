<?php
namespace Laventure\Component\Routing;


use Closure;
use Laventure\Component\Routing\Collection\Route;
use Laventure\Component\Routing\Collection\RouteCollection;
use Laventure\Component\Routing\Dispatcher\RouteDispatcher;
use Laventure\Component\Routing\Dispatcher\RouteDispatcherInterface;
use Laventure\Component\Routing\Exception\RouteNotFoundException;
use Laventure\Component\Routing\Group\RouteGroup;
use Laventure\Component\Routing\Resolver\RouteResolver;
use Laventure\Component\Routing\Resource\Common\Resource;
use Laventure\Component\Routing\Resource\Types\ResourceType;



/**
 * Router
*/
class Router implements RouterInterface
{


        /**
         * Route domain
         *
         * @var string
        */
        protected $domain;



        /**
         * Route collection
         *
         * @var RouteCollection
        */
        protected $collection;




        /**
         * @var Factory
        */
        protected $factory;



        /**
         * Route dispatcher
         *
         * @var RouteDispatcherInterface
        */
        protected $dispatcher;




        /**
         * Route parameter resolver
         *
         * @var RouteResolver
        */
        protected $resolver;




        /**
         * Controller namespace
         *
         * @var string
         */
        protected $namespace;




        /**
         * Route patterns
         *
         * @var array
         */
        protected $patterns = [
            'id'    => '\d+',
            'lang'  => '\w+',
        ];




        /**
         * Route group
         *
         * @var RouteGroup[]
        */
        protected $groups = [];




        /**
         * Resource routes
         *
         * @var array
         */
        protected $resources = [];





        /**
         * BaseRouter constructor.
         *
         * @param RouteDispatcherInterface|null $dispatcher
         */
        public function __construct(RouteDispatcherInterface $dispatcher = null)
        {
            $this->factory    = new Factory();
            $this->collection = new RouteCollection();
            $this->resolver   = new RouteResolver();
            $this->dispatcher = $dispatcher ?? new RouteDispatcher();
        }




        /**
         * Set network domain
         *
         * @param string $domain
         * @return $this
        */
        public function domain(string $domain): self
        {
            $this->domain = $domain;

            return $this;
        }




        /**
         * Controller namespace
         *
         * @param string $namespace
         * @return $this
         */
        public function namespace(string $namespace): self
        {
            $this->resolver->namespace($namespace);

            return $this;
        }



        /**
         * Set globally route patterns
         *
         * @param array $patterns
         * @return $this
         */
        public function patterns(array $patterns): self
        {
            $this->patterns = array_merge($this->patterns, $patterns);

            return $this;
        }




        /**
         * Set globally route pattern
         *
         * @param string $name
         * @param $value
         * @return $this
         */
        public function pattern(string $name, $value): self
        {
            return $this->patterns([$name => $value]);
        }





        /**
         * Add route in collection
         *
         * @param Route $route
         * @return Route
        */
        public function addRoute(Route $route): Route
        {
            return $this->collection->addRoute($route);
        }





        /**
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
         * @param RouteGroup $group
         * @return $this
         */
        public function addGroup(RouteGroup $group): self
        {
            $this->resolver->attachGroup($group);

            $group->map($this);

            $this->groups[] = $group;

            $group->refresh();

            return $this;
        }




        /**
         * @param RouteGroup[] $groups
         * @return $this
         */
        public function addGroups(array $groups): self
        {
            foreach ($groups as $group) {
                $this->addGroup($group);
            }

            return $this;
        }




        /**
         * Add resource
         *
         * @param Resource $resource
         * @return $this
         */
        public function addResource(Resource $resource): self
        {
             $type = $resource->getType();
             $name = $resource->getName();

             $resource->map($this);

             $this->resources[$type][$name] = $resource;

             return $this;
        }




        /**
         * @return RouteGroup[]
        */
        public function getRouteGroups(): array
        {
            return $this->groups;
        }




        /**
         * @return array
         */
        public function getResources(): array
        {
            return $this->resources;
        }




        /**
         * @param string $type
         * @return Resource[]
         */
        public function getResourceByType(string $type): array
        {
            return $this->resources[$type] ?? [];
        }




        /**
         * Get routes
         *
         * @return Route[]
         */
        public function getRoutes(): array
        {
            return $this->collection->getRoutes();
        }





        /**
         * @return array
         */
        public function getPatterns(): array
        {
            return $this->patterns;
        }





        /**
         * @param string $name
         * @return string
        */
        public function getController(string $name): string
        {
            return $this->resolver->getControllerNamespace($name);
        }




        /**
         * @return RouteGroup
        */
        public function getGroup(): RouteGroup
        {
            return $this->resolver->getGroup();
        }



        /**
         * @return string
         */
        public function getNamespace(): string
        {
            return $this->resolver->resolveNamespace();
        }




        /**
         * @return RouteCollection
         */
        public function getCollection(): RouteCollection
        {
            return $this->collection;
        }




        /**
         * @param $methods
         * @param $path
         * @param $action
         * @return Route
         */
        public function makeRoute($methods, $path, $action): Route
        {
             $route = $this->factory->createRoute(
                 $this->resolveMethods($methods),
                 $this->resolvePath($path),
                 $this->resolveAction($action)
             );

             $route->domain($this->domain)
                   ->where($this->patterns)
                   ->name($this->getGroup()->getName())
                   ->middleware($this->getGroup()->getMiddlewares());

             return $route;
        }



        /**
         * @param string $name
         * @param string $controller
         * @param string $type
         * @return Resource
         */
        public function makeResource(string $name, string $controller, string $type = ResourceType::WEB): Resource
        {
              return $this->factory->createResource($name, $controller, $type);
        }





        /**
         * @param array $attributes
         * @param Closure $routes
         * @return RouteGroup
         */
        public function makeRouteGroup(array $attributes, Closure $routes): RouteGroup
        {
             $group = $this->factory->createRouteGroup();

             $group->attributes($attributes)->routes($routes);

             return $group;
        }




        /**
         * Map route params
         *
         * @param string|array $methods
         * @param string $path
         * @param $action
         * @return Route
         */
        public function map($methods, string $path, $action): Route
        {
            return $this->addRoute($this->makeRoute($methods, $path, $action));
        }





        /**
         * Register route group
         *
         * @param array $attributes
         * @param Closure $routes
         * @return $this
         */
        public function group(array $attributes, Closure $routes): self
        {
             return $this->addGroup($this->makeRouteGroup($attributes, $routes));
        }



        /**
         * Add web resource
         *
         * @param string $name
         * @param string $controller
         * @return $this
         */
        public function resource(string $name, string $controller): self
        {
            $webResource = $this->makeResource($name, $controller);

            return $this->addResource($webResource);
        }




        /**
         * Add web resources
         *
         * @param array $resources
         * @return $this
         */
        public function resources(array $resources): self
        {
            foreach ($resources as $name => $controller) {
                $this->resource($name, $controller);
            }

            return $this;
        }





        /**
         * Add api resource
         *
         * @param string $name
         * @param string $controller
         * @return $this
         */
        public function apiResource(string $name, string $controller): self
        {
            $apiResource = $this->makeResource($name, $controller, ResourceType::API);

            return $this->addResource($apiResource);
        }




        /**
         * Add api resources
         *
         * @param array $resources
         * @return void
         */
        public function apiResources(array $resources)
        {
            foreach ($resources as $name => $resource) {
                $this->apiResource($name, $resource);
            }
        }




        /**
         * @inheritDoc
        */
        public function match(string $requestMethod, string $requestPath)
        {
             foreach ($this->getRoutes() as $route) {
                 if ($route->match($requestMethod, $requestPath)) {
                     return $route;
                 }
             }

             return false;
        }





        /**
         * @param Route $route
         * @return mixed
        */
        public function dispatchRoute(Route $route)
        {
              return $this->dispatcher->dispatchRoute($route);
        }





        /**
         * Call route
         *
         * @param string $requestMethod
         * @param string $requestPath
         * @return mixed
         * @throws RouteNotFoundException
        */
        public function run(string $requestMethod, string $requestPath)
        {
              if (! $route = $this->match($requestMethod, $requestPath)) {
                  throw new RouteNotFoundException($requestPath);
              }

              return $this->dispatchRoute($route);
        }





        /**
         * @param array|string $middlewares
         * @return $this
        */
        public function middleware($middlewares): self
        {
            $this->resolver->middleware($middlewares);

            return $this;
        }




        /**
         * @param string $prefix
         * @return $this
         */
        public function prefix(string $prefix): self
        {
            $this->resolver->prefix($prefix);

            return $this;
        }




        /**
         * @param string $name
         * @return $this
         */
        public function name(string $name): self
        {
            $this->resolver->name($name);

            return $this;
        }




        /**
         * @param string $module
         * @return $this
         */
        public function module(string $module): self
        {
            $this->resolver->module($module);

            return $this;
        }




        /**
         * @return void
        */
        public function removePrefixes()
        {
             $this->resolver->removePrefixes();
        }




        /**
         * @param string $name
         * @return bool
        */
        public function has(string $name): bool
        {
            return $this->collection->hasName($name);
        }



        /**
         * @param string $name
         * @return void
         */
        public function remove(string $name)
        {
            $this->collection->removeRouteByName($name);
        }



        /**
         * @inheritDoc
        */
        public function generate(string $name, array $parameters = [])
        {
             return $this->collection->generate($name, $parameters);
        }





        /**
         * @param string $path
         * @return mixed
        */
        public function createRouteNotFoundException(string $path)
        {
              return (function () use ($path) {
                   throw new RouteNotFoundException($path);
              })();
        }





        /**
         * Map route called by method GET
         *
         * @param string $path
         * @param $action
         * @return Route
        */
        public function get(string $path, $action): Route
        {
             return $this->map(['GET'], $path, $action);
       }




       /**
        * Map route called by method POST
        *
        * @param string $path
        * @param $action
        * @return Route
       */
       public function post(string $path, $action): Route
       {
             return $this->map(['POST'], $path, $action);
       }




       /**
        * Map route called by method PUT
        *
        * @param string $path
        * @param $action
        * @return Route
       */
       public function put(string $path, $action): Route
       {
           return $this->map(['PUT'], $path, $action);
       }




       /**
        * Map route called by method DELETE
        *
        * @param string $path
        * @param $action
        * @return Route
       */
       public function delete(string $path, $action): Route
       {
            return $this->map(['DELETE'], $path, $action);
       }





        /**
         * @param $methods
         * @return array
         */
        protected function resolveMethods($methods): array
        {
            return $this->resolver->resolveMethods($methods);
        }




        /**
         * @param string $path
         * @return string
         */
        protected function resolvePath(string $path): string
        {
            return $this->resolver->resolvePath($path);
        }



        /**
         * @param $action
         * @return mixed
        */
        protected function resolveAction($action)
        {
            return $this->resolver->resolveAction($action);
        }
}