<?php
namespace Laventure\Foundation\Service\Generator\Template;

use Laventure\Foundation\Service\Generator\StubGenerator;

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

               $resources[] = $this->generate("resources/views/{$view}", $stub);
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

         return $this->generate('resources/views/layouts/app.tpl.php', $stub);
     }
}