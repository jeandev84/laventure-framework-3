<?php
namespace Laventure\Component\Http\Request\Factory;


use Laventure\Component\Http\Request\ServerRequest;

/**
 * ServerRequestFactory
*/
class ServerRequestFactory
{

    /**
      * @param array $queries
      * @param array $request
      * @param array $attributes
      * @param array $cookies
      * @param array $files
      * @param array $server
      * @return ServerRequest
     */
     public static function create(
         array $queries = [],
         array $request = [],
         array $attributes = [],
         array $cookies = [],
         array $files = [],
         array $server = []
     ): ServerRequest
     {
           return new ServerRequest(
               $queries,
               $request,
               $attributes,
               $cookies,
               $files,
               $server
           );
     }
}