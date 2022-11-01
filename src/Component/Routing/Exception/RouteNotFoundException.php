<?php
namespace Laventure\Component\Routing\Exception;


use Throwable;


/**
 *
*/
class RouteNotFoundException extends \Exception
{

     /**
      * @param $path
      * @param Throwable|null $previous
     */
     public function __construct($path, Throwable $previous = null)
     {
         parent::__construct("Route '{$path}' not found.", 404, $previous);
     }
}