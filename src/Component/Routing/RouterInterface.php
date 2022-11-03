<?php
namespace Laventure\Component\Routing;


/**
 * RouterInterface
*/
interface RouterInterface
{

      /**
       * Determine if the current request method and path match route.
       *
       * @param string $requestMethod
       * @param string $requestPath
       * @return mixed
      */
      public function match(string $requestMethod, string $requestPath);




      /**
       * Generate URI by given name
       *
       * @param $name
       * @param array $parameters
       * @return mixed
      */
      public function generate($name, array $parameters = []);






      /**
       * Get route collection
       *
       * @return mixed
      */
      public function getRoutes();
}