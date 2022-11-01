<?php
namespace Laventure\Foundation\Routing;



use Laventure\Component\FileSystem\FileSystem;
use Laventure\Component\Http\Request\Request;
use Laventure\Component\Http\Response\Response;
use Laventure\Foundation\Application;
use Laventure\Component\Routing\Collection\Route;
use Laventure\Foundation\Routing\Dispatcher\RouteDispatcher;
use Laventure\Component\Routing\Router as LaventureRouter;



/**
 * Router
*/
class Router extends LaventureRouter
{

     /**
      * @var Application
     */
     protected $app;




     /**
      * @var array
     */
     protected $routeMiddlewares = [];




     /**
      * @var array
     */
     protected $paths = [
         'web' => '',
         'api' => ''
     ];




     /**
      * @var string[]
     */
     protected $config = [
         'prefix'      => '',
         'module'      => '',
         'name'        => '',
         'middlewares' => []
     ];



     /**
      * @var FileSystem
     */
     protected $filesystem;




     /**
      * @param Application $app
      * @param FileSystem $fileSystem
     */
     public function __construct(Application $app, FileSystem $fileSystem)
     {
           parent::__construct(new RouteDispatcher($app));
           $this->app        = $app;
           $this->filesystem = $fileSystem;
     }






     /**
      * @param array $middlewares
      * @return Router
     */
     public function middlewares(array $middlewares): Router
     {
          $this->routeMiddlewares = $middlewares;

          return $this;
     }





     /**
      * @param array $paths
      * @return $this
     */
     public function paths(array $paths): self
     {
          $this->paths = array_merge($this->paths, $paths);

          return $this;
     }





     /**
      * @return mixed|string
     */
     public function getWebPath()
     {
          return $this->paths['web'];
     }




     /**
      * @return mixed|string
     */
     public function getApiPath()
     {
         return $this->paths['api'];
     }





     /**
      * @param array $config
      * @return $this
     */
     public function config(array $config): self
     {
          $this->resetRouteConfigs();

          foreach ($config as $name => $value) {
              if (isset($this->config[$name])) {
                 $this->config[$name] = $value;
              }
          }


          return $this;
     }






     /**
      * @return void
     */
     public function resetRouteConfigs()
     {
          $this->config = [
              'prefix'      => '',
              'module'      => '',
              'name'        => '',
              'middlewares' => []
          ];
     }




     /**
      * @return void
     */
     public function loadWebRoutes()
     {
           $this->configureGroup()->load($this->getWebPath());
     }






     /**
      * @return void
     */
     public function loadApiRoutes()
     {
          $this->configureGroup()->load($this->getApiPath());
     }






     /**
      * @return string[]
     */
     public function getRoutePaths(): array
     {
          return $this->paths;
     }




     /**
      * @param Request $request
      * @return Response
     */
     public function dispatch(Request $request): Response
     {
          return $this->dispatcher->dispatchRoute($this->matchRoute($request));
     }





     /**
      * @param Request $request
      * @return Route
     */
     protected function matchRoute(Request $request): Route
     {
         if (! $route = $this->match($request->getMethod(), $path = $request->getRequestUri())) {
              $this->createRouteNotFoundException($path);
         }

        
         $request->withAttributes([
             'route.name'   => $route->getName(),
             'route.action' => $route->getTarget(),
             'route.params' => $route->getMatches()
         ]);


         $this->app->instances([
             Request::class  => $request,
             'current.route' => $route
         ]);

         $this->app->pipe($route->getMiddlewares());

         return $route;
     }




     /**
      * @return FileSystem
     */
     private function configureGroup(): FileSystem
     {
         $this->removePrefixes();

         $this->prefix($this->config['prefix'])
              ->name($this->config['name'])
              ->module($this->config['module'])
              ->middleware($this->config['middlewares']);

         return $this->filesystem;
     }
}