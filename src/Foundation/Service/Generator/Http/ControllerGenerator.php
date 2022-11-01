<?php
namespace Laventure\Foundation\Service\Generator\Http;


use Laventure\Component\FileSystem\FileSystem;
use Laventure\Foundation\Service\Generator\ClassGenerator;

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
       * @param array $credentials
       * @return string
      */
      public function generateController(array $credentials): string
      {
           $credentials = array_merge([
               "DummyNamespace" => "App\\Http\\Controllers",
               "DummyPath"      => "app/Http/Controllers",
               "DummyActions"   => $this->generateActions($credentials)
           ], $credentials);

           return $this->generateClass($credentials);
      }




      public function generateApiController()
      {

      }



      public function generateResourceController()
      {

      }




      /**
       * @param array $credentials
       * @return string
      */
      public function generateActions(array $credentials): string
      {
            return $this->actionGenerator->generateActions($credentials);
      }




      /**
       * @inheritDoc
      */
      protected function dummyStubPath(): string
      {
           return 'http/controller/template';
      }
}