<?php
namespace Laventure\Foundation\Facade\Console;

use Laventure\Component\Container\Facade\Facade;


/**
 * Schedule
*/
class Schedule extends Facade
{

      /**
       * @inheritdoc
      */
      protected static function getFacadeAccessor(): string
      {
          return 'console';
      }
}