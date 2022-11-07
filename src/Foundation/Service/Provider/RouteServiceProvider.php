<?php
namespace Laventure\Foundation\Service\Provider;


use Laventure\Component\Container\Provider\ServiceProvider;
use Laventure\Foundation\Application;
use Laventure\Foundation\Facade\Routing\Route;
use Laventure\Foundation\Routing\Router;


class RouteServiceProvider extends ServiceProvider
{


    /**
     * @var Application
    */
    protected $app;




    /**
     * @var string
    */
    protected $namespace = "App\\Http\\Controllers";





    /**
     * @inheritDoc
    */
    public function register()
    {
         Route::namespace($this->namespace);
         Route::paths($this->routePaths());
         Route::config($this->configureApiRoutes())->loadApiRoutes();
         Route::config($this->configureWebRoutes())->loadWebRoutes();
    }





    /**
     * @return array
    */
    protected function routePaths(): array
    {
        return [
           'api' => '/config/routes/api.php',
           'web' => '/config/routes/web.php'
        ];
    }




    /**
     * @return array
    */
    protected function configureApiRoutes(): array
    {
        return [
            'prefix' => 'api',
            'name'   => 'api.'
        ];
    }




    /**
     * @return array
    */
    protected function configureWebRoutes(): array
    {
         return [];
    }
}