<?php
namespace Laventure\Foundation\Facade\Console;

use Closure;
use Laventure\Component\Console\Command\Command;
use Laventure\Component\Container\Facade\Facade;


/**
 * @method static Command command(string $name, Closure $configure, string $description = null)
 * @method static Command shell()
 *
 * @class Schedule
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