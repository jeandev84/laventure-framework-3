<?php
namespace Laventure\Foundation\Provider;


use Laventure\Component\Container\Container;
use Laventure\Component\Container\Provider\Contract\BootableServiceProvider;
use Laventure\Component\Container\Provider\ServiceProvider;
use Laventure\Component\Dotenv\Dotenv;
use Laventure\Component\FileSystem\FileSystem;
use Laventure\Component\Routing\Generator\UrlGenerator;
use Laventure\Component\Routing\Generator\UrlGeneratorInterface;
use Laventure\Component\Routing\RouterInterface;
use Laventure\Foundation\Application;
use Laventure\Foundation\Facade\Console\Schedule;
use Laventure\Foundation\Facade\Database\DB;
use Laventure\Foundation\Facade\Database\Schema;
use Laventure\Foundation\Facade\Routing\Route;
use Laventure\Foundation\Facade\Routing\Url;
use Laventure\Foundation\Facade\Templating\Asset;
use Laventure\Foundation\Facade\Templating\View;
use Laventure\Foundation\Http\Controller\DefaultController;
use Laventure\Foundation\Routing\Router;


/**
 * ApplicationServiceProvider
*/
class ApplicationServiceProvider extends ServiceProvider implements BootableServiceProvider
{


    /**
     * @var Application
    */
    protected $app;




    /**
     * @var string[]
    */
    protected $provides = [
        FileSystem::class   => ['filesystem'],
        Router::class       => ['router', RouterInterface::class],
        UrlGenerator::class => ['url', UrlGeneratorInterface::class]
    ];





    /**
     * @return void
    */
    public function boot()
    {
        $this->loadEnvironments();
        $this->loadHelpers();
        $this->loadNamespaces();
    }



    /**
     * Load environments
     *
     * @return void
    */
    private function loadEnvironments()
    {
         Dotenv::create($this->app->path())->load();

         $this->app->instances([
             'app.env'   => getenv('APP_ENV'),
             'app.debug' => getenv('APP_DEBUG')
         ]);
    }




    /**
     * @return void
    */
    private function loadHelpers()
    {
         require_once realpath(__DIR__.'/../helpers.php');
    }




    /**
     * @return void
    */
    private function loadNamespaces()
    {
        $this->app->addNamespaces([
            "Route"    => Route::class,
            "Schedule" => Schedule::class,
            "Url"      => Url::class,
            "Asset"    => Asset::class,
            "View"     => View::class,
        ]);
    }




    /**
     * @return void
    */
    private function loadFacades()
    {
       $this->app->addFacades([
           Route::class,
           DB::class,
           Schema::class,
           Url::class,
           Asset::class,
           View::class,
           Schedule::class
       ]);
    }



    private function loadBasePaths() {}





    /**
     * @inheritDoc
    */
    public function register()
    {
        $this->app->singleton(FileSystem::class, function () {
            return $this->app->make(FileSystem::class, ['root' => $this->app['path']]);
        });


        $this->app->singleton(Router::class, function () {
            $router = $this->app->factory(Router::class);
            $router->domain(env('APP_URL'));
            /* $router->get('/', [DefaultController::class, 'index'])->name('default'); */
            return $router;
        });


        $this->app->singleton(UrlGenerator::class, function () {
             return $this->app->make(UrlGenerator::class, [
                 'networkDomain' => env('APP_URL')
             ]);
        });
    }



    /**
     * @return void
    */
    public function terminate()
    {
        $this->loadFacades();
    }
}