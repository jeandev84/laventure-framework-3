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
         Route::config($this->apiPrefixes())->loadApiRoutes();
         Route::config($this->webPrefixes())->loadWebRoutes();
    }





    /**
     * @return array
    */
    private function routePaths(): array
    {
        return [
           'api' => config()->get("paths.routes.api"),
           'web' => config()->get("paths.routes.web")
        ];
    }




    /**
     * @return array
    */
    protected function apiPrefixes(): array
    {
        return [
            'prefix' => 'api',
            'name'   => 'api.'
        ];
    }




    /**
     * @return array
    */
    protected function webPrefixes(): array
    {
         return [];
    }
}