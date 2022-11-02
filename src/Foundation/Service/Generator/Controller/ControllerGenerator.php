<?php
namespace Laventure\Foundation\Service\Generator\Controller;


use Laventure\Component\FileSystem\FileSystem;
use Laventure\Component\Routing\Resource\WebResource;
use Laventure\Foundation\Service\Generator\File\ClassGenerator;

/**
 * ControllerGenerator
*/
class ControllerGenerator extends ClassGenerator
{

      /**
       * @var ActionGenerator
      */
      protected $actionGenerator;




      /**
       * @param FileSystem $filesystem
      */
      public function __construct(FileSystem $filesystem)
      {
            parent::__construct($filesystem);

            $this->actionGenerator = new ActionGenerator($filesystem);
      }




      /**
       * @param $controller
       * @param array $actions
       * @param array $options
       * @return string
      */
      public function generateController($controller, array $actions = [], array $options = []): string
      {
           $credentials = array_merge([
               "DummyStubPath"  => "controller/template",
               "DummyNamespace" => "App\\Http\\Controllers",
               "DummyClass"     => $controller,
               "DummyPath"      => "app/Http/Controllers",
               "DummyActions"   => $this->generateActions($actions, $options)
           ], $options);

           return $this->generateClass($credentials);
      }




      /**
       * @param $controller
       * @return string
      */
      public function generateApiController($controller): string
      {
           $controller = preg_replace('#Api/#', '', $controller);

           return $this->generateController($controller, [], [
               "DummyNamespace" => "App\\Http\\Controllers\\Api",
               "DummyPath"      => "app/Http/Controllers/Api",
               "DummyStubPath"  => "controller/resource/api/template"
           ]);
      }




      /**
       * @param $controller
       * @return string
      */
      public function generateResourceController($controller): string
      {
          return $this->generateController($controller, [], [
              "DummyStubPath"     => "controller/resource/web/template",
              "DummyResourcePath" => $this->resourcePath($controller)
          ]);
      }




      /**
       * @param $controller
       * @return array
      */
      public function generateResourcePaths($controller): array
      {
           $resources = [];

           foreach (WebResource::views() as $action) {
               $resources[] = sprintf('%s.tpl.php', $this->resourcePath($controller, $action));
           }

           return $resources;
      }





      /**
       * @param $actions
       * @param array $options
       * @return string
      */
      public function generateActions($actions, array $options = []): string
      {
            return $this->actionGenerator->generateActions($actions, $options);
      }





      /**
       * @param $resource
       * @param string|null $view
       * @return string
      */
      public function resourcePath($resource, string $view = null): string
      {
          $resourcePath = str_replace('Controller', '', $resource);
          $resourcePath = strtolower($resourcePath);

          return $view ?  "{$resourcePath}/{$view}" : $resourcePath;
      }
}