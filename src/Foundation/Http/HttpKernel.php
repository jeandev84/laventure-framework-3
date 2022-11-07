<?php
namespace Laventure\Foundation\Http;

use Exception;
use Laventure\Component\Http\Request\Request;
use Laventure\Component\Http\Response\Response;
use Laventure\Contract\Http\Kernel;
use Laventure\Foundation\Application;
use Laventure\Foundation\Http\Middleware\Api\BarApiMiddleware;
use Laventure\Foundation\Http\Middleware\Api\FooApiMiddleware;
use Laventure\Foundation\Http\Middleware\SessionStartMiddleware;
use Laventure\Foundation\Http\Middleware\Web\BarWebMiddleware;
use Laventure\Foundation\Http\Middleware\Web\FooWebMiddleware;
use Laventure\Foundation\Routing\Router;


/**
 * Base Http Kernel
*/
abstract class HttpKernel implements Kernel
{

     /**
      * @var Application
     */
     protected $app;




     /**
      * @var Router
     */
     protected $router;




     /**
      * @var array
     */
     private $middlewarePriority = [
         SessionStartMiddleware::class
     ];




     /**
      * @var array
     */
     protected $middlewares = [];





     /**
      * @var array
     */
     protected $routeMiddlewares = [
         'api' => [
             'foo' => FooApiMiddleware::class,
             'bar' => BarApiMiddleware::class
         ],
         'web' => [
             'foo' => FooWebMiddleware::class,
             'bar' => BarWebMiddleware::class
         ]
     ];





     /**
      * HttpKernel constructor.
      *
      * @param Application $app
      * @param Router $router
     */
     public function __construct(Application $app, Router $router)
     {
           $this->app    = $app;
           $this->router = $router;
     }







     /**
      * @inheritDoc
     */
     public function handle(Request $request): Response
     {
         try {

             $this->bootMiddlewares();

             $response = $this->dispatchRoute($request);

         } catch (Exception $e) {

             $response = $this->renderException($e);
         }

         /* $this->app['events']->dispatch(); */


         return $response;
     }




     /**
      * @inheritDoc
     */
     public function terminate(Request $request, Response $response)
     {
          $this->app->terminate($request, $response);
     }




     /**
      * @param Request $request
      * @return Response
     */
     protected function dispatchRoute(Request $request): Response
     {
           return $this->router->middlewares($this->routeMiddlewares)
                               ->dispatch($request);
     }




     /**
      * @param Exception $e
      * @return Response
     */
     protected function renderException(Exception $e): Response
     {
          return new Response($e->getMessage(), $e->getCode());
     }




     /**
      * @return string[]
      */
     private function getPriorityMiddlewares(): array
     {
          return array_merge($this->middlewarePriority, $this->middlewares);
     }




     /**
      * @return void
     */
     private function bootMiddlewares()
     {
          $this->app->addMiddlewares($this->getPriorityMiddlewares());
     }
}