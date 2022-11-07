<?php
namespace Laventure\Foundation\Service\Generator\View;

use Laventure\Foundation\Service\Generator\File\StubGenerator;

/**
 * @class TemplateGenerator
*/
class TemplateGenerator extends StubGenerator
{


       /**
        * @param $path
        * @return string
      */
      public function getTemplatePath($path): string
      {
           return trim($this->config("TemplatePath"), "\\/") . "/" . $path;
      }




      /**
       * @param array $views
       *
       * @return string[]
     */
     public function generateViews(array $views): array
     {
           $resources = [];

           foreach ($views as $view) {

               $stub = $this->generateStub("template/view", [

               ]);

               if (! $this->generated($viewPath = $this->getTemplatePath($view))) {
                   $resources[] = $this->generate($viewPath, $stub);
               }
           }

           return $resources;
     }




     /**
      * @return string|null
     */
     public function generateLayout(): ?string
     {
         $stub = $this->generateStub("template/layout", [

         ]);

         if ($this->generated($layoutPath = $this->getLayoutPath('default.tpl.php'))) {
                return false;
         }

         return $this->generate($layoutPath, $stub);
     }



     /**
      * @param $path
      * @return string
     */
     public function getLayoutPath($path): string
     {
          return $this->getTemplatePath("layouts/{$path}");
     }
}