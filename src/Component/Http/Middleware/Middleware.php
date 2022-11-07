<?php
namespace Laventure\Component\Http\Middleware;

use Closure;
use Laventure\Component\Http\Middleware\Contract\MiddlewareInterface;
use Laventure\Component\Http\Middleware\Contract\RequestHandlerInterface;
use Laventure\Component\Http\Request\Request;
use Laventure\Component\Http\Response\Response;


class Middleware
{

     /**
      * @var Closure
     */
     private $start;





     /**
      * Middleware constructor
     */
     public function __construct()
     {
          $this->start = function () {
                return '';
          };
     }






     /**
      * Add middlewares
      *
      * @param object $middleware
      * @return $this
     */
     public function add(object $middleware): self
     {
          $next = $this->start;

          $this->start = function (Request $request) use ($middleware, $next) {
                return $this->process($middleware, $request, $next);
          };

          return $this;
     }





     /**
      * Run middlewares
      *
      * @param Request $request
      * @return mixed
     */
     public function handle(Request $request)
     {
         return call_user_func($this->start, $request);
     }





     /**
      * @param object $middleware
      * @param Request $request
      * @param callable $next
      * @return callable|null
     */
     private function process(object $middleware, Request $request, callable $next): ?callable
     {
          if (is_callable([$middleware, '__invoke'])) {
                return $middleware->__invoke($request, $next);
          }

          if ($middleware instanceof RequestHandlerInterface) {
               $next = $middleware->handle($request, $next);
          }

          if ($middleware instanceof MiddlewareInterface) {
               $middleware->terminate($request, new Response());
          }

          return $next($request);
     }
}