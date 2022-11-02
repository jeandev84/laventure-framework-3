<?php
namespace Laventure\Foundation\Service\Generator\Render;

use Laventure\Foundation\Service\Generator\File\StubGenerator;

/**
 * @class TemplateGenerator
*/
class TemplateGenerator extends StubGenerator
{

      /**
       * @param array $views
       * @param string $stubPath
       * @return string[]
     */
     public function generateViews(array $views, string $stubPath = 'template/view'): array
     {
           $resources = [];

           foreach ($views as $view) {

               $stub = $this->generateStub($stubPath, [

               ]);

               if (! $this->generated($viewPath = "resources/views/{$view}")) {
                   $resources[] = $this->generate($viewPath, $stub);
               }
           }

           return $resources;
     }




     /**
      * @param string $stubPath
      * @return string|null
     */
     public function generateLayout(string $stubPath = "template/layout"): ?string
     {
         $stub = $this->generateStub($stubPath, [

         ]);

         if ($this->generated($layoutPath = 'resources/views/layouts/default.tpl.php')) {
                return false;
         }

         return $this->generate($layoutPath, $stub);
     }
}