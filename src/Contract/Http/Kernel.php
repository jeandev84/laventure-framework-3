<?php
namespace Laventure\Contract\Http;


use Laventure\Component\Http\Request\Request;
use Laventure\Component\Http\Response\Response;


/**
 * HTTP Kernel
*/
interface Kernel
{


      /**
        * Get request and return response
        *
        * @param Request $request
        * @return mixed
      */
      public function handle(Request $request): Response;





      /**
       * Map the current request and current response for terminate handle.
       *
       * @param Request $request
       * @param Response $response
       * @return mixed
      */
      public function terminate(Request $request, Response $response);
}