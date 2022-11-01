<?php
namespace Laventure\Foundation\Facade\Templating;


use Laventure\Component\Container\Facade\Facade;


/**
 * @method static string link(string $link)
 * @method static string links(array $files = [])
*/
class Asset extends Facade
{
     protected static function getFacadeAccessor(): string
     {
         return 'asset';
     }
}