<?php
namespace Laventure\Foundation\Http\Controller;


use Laventure\Component\Container\Common\ContainerAwareTrait;
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
       * @param string $path
       * @param int $code
       * @return RedirectResponse
      */
      public function redirectTo(string $path, int $code = 301): RedirectResponse
      {
           return new RedirectResponse($path, $code);
      }




      /**
       * @param array $data
       * @param int $statusCode
       * @param array $headers
       * @return JsonResponse
      */
      public function json(array $data, int $statusCode = 200, array $headers = []): JsonResponse
      {
           return new JsonResponse($data, $statusCode, $headers);
      }
}