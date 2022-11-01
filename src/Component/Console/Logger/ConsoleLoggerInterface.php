<?php
namespace Laventure\Component\Console\Logger;

use Exception;

interface ConsoleLoggerInterface
{
      /**
       * @param Exception $e
       * @return mixed
      */
      public function log(Exception $e);
}