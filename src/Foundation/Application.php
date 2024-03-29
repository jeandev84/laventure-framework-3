<?php
namespace Laventure\Foundation;

use Laventure\Component\Container\Container;
use Laventure\Component\Container\Contract\ContainerInterface;
use Laventure\Component\Http\Middleware\Middleware;
use Laventure\Component\Http\Request\Request;
use Laventure\Component\Http\Response\Response;
use Laventure\Foundation\Service\Provider\ApplicationServiceProvider;
use Laventure\Foundation\Service\Provider\ConsoleServiceProvider;
use Laventure\Foundation\Service\Provider\DatabaseServiceProvider;
use Laventure\Foundation\Service\Provider\EventDispatcherServiceProvider;
use Laventure\Foundation\Service\Provider\FileGeneratorServiceProvider;
use Laventure\Foundation\Service\Provider\RouteServiceProvider;
use Laventure\Foundation\Service\Provider\StorageServiceProvider;
use Laventure\Foundation\Service\Provider\UrlGeneratorServiceProvider;
use Laventure\Foundation\Service\Provider\ViewServiceProvider;


/**
 * Application
*/
final class Application extends Container
{

      /**
       * name of application
       *
       * @var string
      */
      protected $name = 'Laventure';



      /**
       * version of application
       *
       * @var string
      */
      protected $version = '1.0';




      /**
       * base path of application
       *
       * @var string
      */
      protected $basePath;






      /**
       * @var array
      */
      protected $namespaces = [];






      /**
       * Application constructor.
       *
       * @param string|null $basePath
      */
      public function __construct(string $basePath = null)
      {
            if ($basePath) {
                $this->root($basePath);
            }

            $this->registerBaseBindings();
            $this->registerBaseProviders();
            $this->loadNamespaces();
      }







      /**
       * @param string $path
       * @return $this
      */
      public function root(string $path): self
      {
          $path = rtrim(realpath($path), '\\/');

          $this->binds(compact('path'));

          $this->basePath = $path;

          return $this;
      }


      
      
      
      /**
       * Set version of application
       * 
       * @param string $version
       * @return $this
      */
      public function version(string $version): self
      {
           $this->version = $version;
           
           return $this;
      }

      
      
      
      
      /**
       * Load path
       * 
       * @param string $path
       * @return string
      */
      public function path(string $path = ''): string
      {
           return $this->basePath . ($path ? DIRECTORY_SEPARATOR . trim($path, '\\/') : $path);
      }





      /**
       * @return string
      */
      public function getBasePath(): string
      {
          return $this->basePath;
      }







      /**
       * Get application name
       *
       * @return string
      */
      public function getName(): string
      {
          return $this->name;
      }




      /**
       * @param $timezone
       * @return void
      */
      public function setTimezone($timezone)
      {
           if ($timezone) {

               date_default_timezone_set($timezone);

               $this->bind('app.timezone', $timezone);
           }
      }






      /**
       * @return string
      */
      public function getTimezone(): string
      {
           return $this->get('app.timezone');
      }







      /**
       * Get application version
       *
       * @return string
      */
      public function getVersion(): string
      {
           return $this->version;
      }







      /**
       * Add namespaces
       *
       * @param string[] $namespaces
       * @return void
      */
      public function addClassAliases(array $namespaces)
      {
          foreach ($namespaces as $alias => $namespace) {
             $this->namespaces[$alias] = $namespace;
          }
      }






      /**
       * Add middleware
       * 
       * @param string[] $middlewares
       * @return void
      */
      public function addMiddlewares(array $middlewares)
      {
          foreach ($middlewares as $middleware) {
              $this['middleware']->add($this->get($middleware));
          }
      }






      /**
       * @param string $name
       * @return $this
      */
      public function name(string $name): self
      {
          $this->name = $name;

          return $this;
      }







      /**
       * Set HTTP Kernel
       *
       * @param $httpKernel
       * @return $this
      */
      public function kernelHTTP($httpKernel): self
      {
           $this->singleton(\Laventure\Contract\Http\Kernel::class, $httpKernel);

           return $this;
      }






      /**
       * Return HTTP Kernel
       *
       * @return mixed
      */
      public function getHttpKernel()
      {
          return $this->get(\Laventure\Contract\Http\Kernel::class);
      }






      /**
       * Set Console Kernel
       *
       * @param $consoleKernel
       * @return $this
      */
      public function kernelConsole($consoleKernel): self
      {
           $this->singleton(\Laventure\Contract\Console\Kernel::class, $consoleKernel);

           return $this;
      }





      /**
       * Return Console Kernel
       *
       * @return mixed
      */
      public function getConsoleKernel()
      {
           return $this->get(\Laventure\Contract\Console\Kernel::class);
      }






      /**
       * Set Exception Handler
       *
       * @param $exceptionHandler
       * @return $this
      */
      public function exceptionHandler($exceptionHandler): self
      {
           $this->singleton(\Laventure\Contract\Debug\ExceptionHandler::class, $exceptionHandler);

           return $this;
      }






      /**
       * Return Exception Handler
       *
       * @return mixed
      */
      public function getExceptionHandler()
      {
           return $this->get(\Laventure\Contract\Debug\ExceptionHandler::class);
      }






      /**
       * @param Request $request
       * @param Response $response
       * @return void
      */
      public function terminate(Request $request, Response $response)
      {
             $this['middleware']->handle($request);
             $response->sendBody($request);
      }



      
      

      /**
       * @return void
      */
      private function loadNamespaces()
      {
          foreach ($this->namespaces as $alias => $namespace) {
               \class_alias($namespace, $alias);
          }
      }





      
      /**
       * @return void
      */
      private function registerBaseBindings()
      {
           self::setInstance($this);

           $this->instances([
              Container::class => $this,
              ContainerInterface::class => $this,
              'app' => $this
           ]);

           $this->singletons([
              get_class()  => $this,
              'middleware' => $this->make(Middleware::class)
           ]);
      }





      /**
       * Register base providers
       *
       * @return void
      */
      private function registerBaseProviders()
      {
         $this->addProviders([
             ApplicationServiceProvider::class,
             EventDispatcherServiceProvider::class,
             StorageServiceProvider::class,
             DatabaseServiceProvider::class,
             RouteServiceProvider::class,
             UrlGeneratorServiceProvider::class,
             ViewServiceProvider::class,
             FileGeneratorServiceProvider::class,
             ConsoleServiceProvider::class
         ]);
      }
}