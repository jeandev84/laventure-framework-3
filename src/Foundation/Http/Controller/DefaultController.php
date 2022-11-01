<?php
namespace Laventure\Foundation\Http\Controller;

use Laventure\Component\Http\Response\Response;
use Laventure\Component\Templating\Renderer\Renderer;

/**
 * DefaultController
*/
class DefaultController extends Controller
{
      /**
       * @param Renderer $renderer
      */
      public function __construct(Renderer $renderer)
      {
           $renderer->withLayout(null);
           $renderer->basePath(__DIR__ . '/Resources/views');
      }




      /**
       * @return Response
      */
      public function index(): Response
      {
           return view('welcome');
      }
}