<?php
namespace Laventure\Foundation\Service\Generator\Controller;



class ApiControllerGenerator extends ControllerGenerator
{

      /**
       * @param $controller
       * @return string
      */
      public function generateApiResource($controller): string
      {
           $controller = preg_replace('#Api/#', '', $controller);

           $credentials = array_merge([
               "DummyStubPath"  => "controller/resource/api/template",
               "DummyClass"     => $controller,
           ]);

           return $this->generateClass($credentials);
      }
}