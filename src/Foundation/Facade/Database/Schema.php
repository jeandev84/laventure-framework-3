<?php
namespace Laventure\Foundation\Facade\Database;

use Closure;
use Laventure\Component\Container\Facade\Facade;


/**
 * @method static bool create(string $table, Closure $closure)
 * @method static bool table(string $table, Closure $closure)
 * @method static bool dropIfExists(string $table)
 *
 * Schema facade
*/
class Schema extends Facade
{

      /**
       * @inheritdoc
      */
      protected static function getFacadeAccessor(): string
      {
          return 'schema';
      }
}