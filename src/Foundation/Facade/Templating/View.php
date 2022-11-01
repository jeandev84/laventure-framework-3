<?php
namespace Laventure\Foundation\Facade\Templating;

use Laventure\Component\Container\Facade\Facade;


/**
 * @method static string|null render(string $template, array $data = [])
 * @method static mixed includePath(string $path, array $data = [])
 *
 * View
*/
class View extends Facade
{
     /**
      * @return string
     */
     protected static function getFacadeAccessor(): string
     {
          return 'view';
     }
}