<?php
namespace Laventure\Foundation\Service\Provider;


use Laventure\Component\Config\Config;
use Laventure\Component\Config\Loaders\ArrayLoader;
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
        Config::class       => ['config'],
        Router::class       => ['router', RouterInterface::class],
        UrlGenerator::class => ['url', UrlGeneratorInterface::class],
    ];





    /**
     * @return void
    */
    public function boot()
    {
        $this->loadEnvironments();
        $this->loadHelpers();
        $this->loadClassAlias();
    }




    /**
     * Load environments
     *
     * @return void
    */
    private function loadEnvironments()
    {
         Dotenv::create($this->app->path())->load();

         $this->app->binds([
             'app.env'   => getenv('APP_ENV'),
             'app.debug' => getenv('APP_DEBUG')
         ]);
    }




    /**
     * @return void
    */
    private function loadHelpers()
    {
         require_once realpath(__DIR__.'/../../helpers.php');
    }




    /**
     * @return void
    */
    private function loadClassAlias()
    {
        $this->app->addClassAliases([
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





    /**
     * @inheritDoc
    */
    public function register()
    {
        $this->app->singleton(FileSystem::class, function () {
            return $this->app->make(FileSystem::class, ['root' => $this->app['path']]);
        });


        $this->app->singleton(Config::class, function (FileSystem $fs) {

            /** @var Config $config */
            $config = $this->app->factory(Config::class);
            $arrays = $fs->collection('/config/params/*.php')->configs();
            $arrays = array_merge($arrays, $this->configurations());

            $config->load([
                new ArrayLoader($arrays)
            ]);

            return $config;
        });



        $this->app->singleton(Router::class, function () {
            $router = $this->app->factory(Router::class);
            $router->domain(env('APP_URL'));
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





    /**
     * @return \string[][]
    */
    private function configNamespaces(): array
    {
        return [
            "controllers"         => [
                "web" => "App\\Http\\Controllers",
                "api" => "App\\Http\\Controllers\\Api",
            ],
            "middlewares"         => "App\\Middlewares",
            "entities"            => "App\\ORM\\Mapper\\Entity",
            "repositories"        => "App\\ORM\\Mapper\\Repository",
            "fixtures"            => "App\\ORM\\Mapper\\Fixtures",
            "models"              => "App\\ORM\\Model",
            "commands"            => "App\\Console\\Commands",
            "events"              => "App\\Events",
            "providers"           => "App\\Service\\Providers",
            "forms"               => "App\\Service\\Form",
            "migrations"          => [
                "mapper" => "App\\ORM\\Mapper\\Migrations",
                "model"  => "App\\ORM\\Model\\Migrations",
            ]
        ];
    }





    /**
     * @return array
    */
    private function configPaths(): array
    {
         $paths = [];

         foreach ($this->configNamespaces() as $name => $namespace) {
             $paths[$name] = str_replace(["App", "\\"], ['app', DIRECTORY_SEPARATOR], $namespace);
         }

         return $paths;
    }





    /**
     * @return array
    */
    private function configurations(): array
    {
         return [
            "namespaces" => $this->configNamespaces(),
            "paths"      => $this->configPaths()
         ];
    }
}