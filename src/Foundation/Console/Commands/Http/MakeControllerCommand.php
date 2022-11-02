<?php
namespace Laventure\Foundation\Console\Commands\Http;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Component\Routing\Resource\ApiResource;
use Laventure\Component\Routing\Resource\WebResource;
use Laventure\Foundation\Service\Generator\Controller\ControllerGenerator;
use Laventure\Foundation\Service\Generator\Route\RouteGenerator;
use Laventure\Foundation\Service\Generator\Render\TemplateGenerator;


class MakeControllerCommand extends Command
{


     /**
      * @var ControllerGenerator
     */
     protected $controllerGenerator;




     /**
      * @var TemplateGenerator
     */
     protected $templateGenerator;





     /**
      * @var RouteGenerator
     */
     protected $routeGenerator;




     /**
       * @param ControllerGenerator $controllerGenerator
       * @param TemplateGenerator $templateGenerator
     */
     public function __construct(
         ControllerGenerator $controllerGenerator,
         TemplateGenerator $templateGenerator,
         RouteGenerator $routeGenerator
     )
     {
           parent::__construct('make:controller');
           $this->controllerGenerator = $controllerGenerator;
           $this->templateGenerator   = $templateGenerator;
           $this->routeGenerator      = $routeGenerator;
     }






     /**
      * Example :
      *
      * $ php console make:controller DemoController
      * $ php console make:controller DemoController --resource
      * $ php console make:controller Resource/Users/UserController --resource
      * $ php console make:controller Admin/UserController --resource
      * $ php console make:controller DemoController --api
      * $ php console make:controller V1/DemoController --api
      * $ php console make:controller Api/V1/DemoController --api
      *
      *
      * @param InputInterface $input
      * @param OutputInterface $output
      * @return int
     */
     public function execute(InputInterface $input, OutputInterface $output): int
     {
         if ($controllerPath = $this->makeController($input)) {

              $output->success("Controller '$controllerPath' successfully generated.");

              if ($input->flag('resource')) {

                  if ($layout = $this->makeLayout()) {
                      $output->success("Layout '{$layout}' successfully generated.");
                  }

                  if ($views = $this->makeResourceViews($input->getArgument())) {
                       $output->success("View files successfully generated:");
                       foreach ($views as $view) {
                            $output->success($view);
                       }
                  }
              }

              if ($routePath = $this->makeRouteResource($input)) {
                   $output->success("New route resource added to '{$routePath}'");
              }
         }

         return Command::SUCCESS;
     }






     /**
      * @param InputInterface $input
      * @return string
     */
     protected function makeController(InputInterface $input): string
     {
           $controller = $input->getArgument();

           if($input->flag('resource')) {
               return $this->controllerGenerator->generateResourceController($controller);
           } elseif ($input->flag('api')) {
               return $this->controllerGenerator->generateApiController($controller);
           }

           return $this->controllerGenerator->generateController($controller);
     }




     /**
      * @param $controller
      * @return string[]
     */
     public function makeResourceViews($controller): array
     {
           $views = $this->controllerGenerator->generateResourcePaths($controller);

           return $this->templateGenerator->generateViews($views);
     }




     /**
      * @return string|null
     */
     protected function makeLayout(): ?string
     {
          return $this->templateGenerator->generateLayout();
     }




     /**
      * @param InputInterface $input
      * @return string|false
     */
     protected function makeRouteResource(InputInterface $input)
     {
          $controller = $input->getArgument();

          if ($input->flag('api')) {
               return $this->routeGenerator->generateResourceApi($controller);
          } elseif($input->flag('resource')) {
               return $this->routeGenerator->generateResourceWeb($controller);
          }

          return false;
     }
}