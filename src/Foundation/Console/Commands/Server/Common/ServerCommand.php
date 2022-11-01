<?php
namespace Laventure\Foundation\Console\Commands\Server\Common;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Command\ShellCommand;


/**
 * ServerCommand
*/
abstract class ServerCommand extends ShellCommand
{

     /**
      * Default host where server local will be run
      *
      * @var string
     */
     protected $host   = '127.0.0.1:8000';





     /**
      * @param null $parsed
      * @return string
     */
     protected function host($parsed = null): string
     {
          return $parsed ?: $this->host;
     }






     /**
      * @param $parsed
      * @return string
     */
     protected function port($parsed = null): string
     {
          return $parsed ?: '8000';
     }






     /**
      * @param null $port
      * @return string
     */
     protected function link($port = null): string
     {
          $port = $port ?: '8000';

          return "http://localhost:{$port}";
     }
}