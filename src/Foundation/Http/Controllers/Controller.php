<?php
namespace Laventure\Foundation\Http\Controllers;


use Laventure\Component\Container\Common\ContainerAwareTrait;
use Laventure\Component\Container\Container;
use Laventure\Component\Container\Contract\ContainerAwareInterface;
use Laventure\Component\Http\Response\JsonResponse;
use Laventure\Component\Http\Response\RedirectResponse;
use Laventure\Component\Http\Response\Response;


/**
 * Controller
*/
abstract class Controller implements ContainerAwareInterface
{

       use ContainerAwareTrait;



       /**
        * View Layout
        *
        * @var string
       */
       protected $layout = 'layouts/default';



       /**
        * @param Container $container
        * @return void
       */
       public function setContainer(Container $container)
       {
            $container->bind('view.layout', $this->getLayout());
            $this->container = $container;
       }




       /**
        * @param $id
        * @return mixed|string
       */
       public function get($id)
       {
            return $this->container->get($id);
       }





      /**
       * @param $template
       * @param array $data
       * @return Response
      */
      public function render($template, array $data = []): Response
      {
           return view($template, $data);
      }






      /**
       * @param string $template
       * @param array $data
       * @return mixed
      */
      public function renderTemplate(string $template, array $data = [])
      {
           return $this->get('view')->render($template, $data);
      }





      /**
       * @return string
      */
      protected function getLayout(): string
      {
            return $this->layout;
      }
}