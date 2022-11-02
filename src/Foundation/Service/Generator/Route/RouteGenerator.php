<?php
namespace Laventure\Foundation\Service\Generator\Route;


use Laventure\Foundation\Service\Generator\StubGenerator;


/**
 * RouteGenerator
*/
class RouteGenerator extends StubGenerator
{

       /**
        * @param string $controller
        * @return string|false
       */
       public function generateResourceApi(string $controller)
       {
             [$name, $controller] = $this->makeResourceCredentials($controller);

             $stub = $this->generateStub('route/resource/api/template', [
                 'ResourceName'       => $name,
                 'ResourceController' =>  $controller
             ]);

             if(! $this->writeTo($routePath = 'config/routes/api.php', $stub)) {
                 return false;
             }

             return $routePath;
       }




       /**
        * @param string $controller
        * @return string|false
       */
       public function generateResourceWeb(string $controller)
       {
           [$name, $controller] = $this->makeResourceCredentials($controller);

           $stub = $this->generateStub('route/resource/web/template', [
               'ResourceName'       => $name,
               'ResourceController' => $controller
           ]);

           if(! $this->writeTo($routePath = 'config/routes/web.php', $stub)) {
                 return false;
           }

           return $routePath;
       }





       /**
        * @param $controller
        * @return array
       */
       private function makeResourceCredentials($controller): array
       {
            $components = explode('/', $controller);

            $controller = end($components);
            $name       = strtolower(str_replace('Controller', '', $controller));

            return [$name, $controller];
       }

}