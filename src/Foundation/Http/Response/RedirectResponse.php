<?php
namespace Laventure\Foundation\Http\Response;

use Laventure\Component\Http\Response\RedirectResponse as Redirect;
use Laventure\Foundation\Routing\Router;


/**
 * RedirectResponse
*/
class RedirectResponse extends Redirect
{

      /**
       * @var Router
      */
      protected $router;




      /**
       * @var string
      */
      protected $refererPath;




      /**
       * @param Router $router
       * @param string|null $refererPath
      */
      public function __construct(Router $router, string $refererPath = null)
      {
           parent::__construct(null, 301, []);
           $this->router      = $router;
           $this->refererPath = $refererPath;
      }





      /**
        * Redirect to path by given name
        *
        * @param string $name
        * @param array $parameters
        * @return void
      */
      public function to(string $name, array $parameters = [])
      {
           $this->path($this->router->generate($name, $parameters));
      }




      /**
       * Redirect to home page
       *
       * @return void
      */
      public function home()
      {
          $this->path('/');
      }




      /**
       * @param $path
       * @return void
      */
      public function withRefererPath($path)
      {
            $this->refererPath = $path;
      }





      /**
       * Redirect to HTTP_REFERER
       *
       * @return void
      */
      public function back()
      {
           $this->path($this->refererPath);
      }
}