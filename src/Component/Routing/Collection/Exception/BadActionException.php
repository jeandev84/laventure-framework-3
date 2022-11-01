<?php
namespace Laventure\Component\Routing\Collection\Exception;


use Throwable;

class BadActionException extends \BadMethodCallException
{
       /**
        * @param $controller
        * @param $action
        * @param Throwable|null $previous
       */
       public function __construct($controller, $action, Throwable $previous = null)
       {
           $message = "Method '{$action}' does not exist in  controller '{$controller}'";

           parent::__construct($message, 400, $previous);
       }
}