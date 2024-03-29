<?php
namespace Laventure\Foundation\Facade\Routing;

use Laventure\Component\Container\Facade\Facade;
use Laventure\Foundation\Routing\Router;


/**
 * @method static Router map(array|string $methods, string $path, $action)
 * @method static Router get(string $path, $action)
 * @method static Router post(string $path, $action)
 * @method static Router put(string $path, $action)
 * @method static Router delete(string $path, $action)
 * @method static Router group(array $attributes, \Closure $routes)
 * @method static Router prefix(string $prefix)
 * @method static Router module(string $module)
 * @method static Router name(string $name)
 * @method static Router middleware(string $middleware)
 * @method static string generate(string $name, array $parameters = [])
 * @method static Router resource(string $name, string $controller)
 * @method static Router resources(array $resources)
 * @method static Router apiResource(string $name, string $controller)
 * @method static Router apiResources(array $resources)
 * @method static Router namespace(string $namespace)
 * @method static Router paths(array $paths)
 * @method static Router config(array $parameters)
 *
 * Route facade
*/
class Route extends Facade
{

    /**
     * @return string
    */
    protected static function getFacadeAccessor(): string
    {
        return 'router';
    }
}