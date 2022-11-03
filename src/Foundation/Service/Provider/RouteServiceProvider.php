<?php
namespace Laventure\Foundation\Service\Provider;


use Laventure\Component\Container\Provider\ServiceProvider;
use Laventure\Foundation\Application;
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
     * @return Router
    */
    private function router(): Router
    {
         return $this->app['router'];
    }





    /**
     * @inheritDoc
    */
    public function register()
    {
         $this->router()->namespace($this->namespace);
         $this->router()->paths($this->routePaths());
         $this->router()->config($this->configureApiRoutes())->loadApiRoutes();
         $this->router()->config($this->configureWebRoutes())->loadWebRoutes();
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