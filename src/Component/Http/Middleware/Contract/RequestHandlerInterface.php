<?php
namespace Laventure\Component\Http\Middleware\Contract;


use Laventure\Component\Http\Request\Request;


/**
 *  RequestHandlerInterface
*/
interface RequestHandlerInterface
{
      /**
       * @param Request $request
       * @param callable $next
       * @return callable
      */
      public function handle(Request $request, callable $next): callable;
}