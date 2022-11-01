<?php
namespace Laventure\Foundation\Facade\Routing;

use Laventure\Component\Container\Facade\Facade;

/**
 * @method static string generate(string $name, array $parameters = [])
 * @method static string absoluteURL(string $path, array $parameters = [])
 * @method static string absolutePath(string $path)
 * @method static string relativePath(string $path)
 * @method static string network()
 *
 *
 * Url
*/
class Url extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'url';
    }
}