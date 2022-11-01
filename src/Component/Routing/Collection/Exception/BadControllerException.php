<?php
namespace Laventure\Component\Routing\Collection\Exception;

use Throwable;


/**
 *
*/
class BadControllerException extends \Exception
{

     /**
      * @param string $controllerName
      * @param int $code
      * @param Throwable|null $previous
     */
     public function __construct($controllerName, int $code = 400, Throwable $previous = null)
     {
           $message = sprintf("Controller '%s' does not exist.", $controllerName);

           parent::__construct($message, $code, $previous);
     }
}