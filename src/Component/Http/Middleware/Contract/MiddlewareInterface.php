<?php
namespace Laventure\Component\Http\Middleware\Contract;

use Laventure\Component\Http\Request\Request;
use Laventure\Component\Http\Response\Response;



/**
 * MiddlewareInterface
*/
interface MiddlewareInterface extends RequestHandlerInterface
{

      /**
       * @param Request $request
       * @param Response $response
       * @return mixed
     */
     public function terminate(Request $request, Response $response);
}