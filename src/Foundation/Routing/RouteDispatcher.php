<?php
namespace Laventure\Foundation\Routing;



use Laventure\Component\Http\Response\JsonResponse;
use Laventure\Component\Http\Response\Response;
use Laventure\Component\Routing\Collection\Exception\BadControllerException;
use Laventure\Component\Routing\Collection\Route;
use Laventure\Component\Routing\Dispatcher\RouteDispatcherInterface;
use Laventure\Foundation\Application;


/**
 * RouteDispatcher
*/
class RouteDispatcher implements RouteDispatcherInterface
{


    /**
     * @var Application
    */
    protected $app;




    /**
     * @param Application $app
    */
    public function __construct(Application $app)
    {
          $this->app = $app;
    }






    /**
     * @inheritDoc
     * @throws BadControllerException
    */
    public function dispatchRoute(Route $route): Response
    {
         if (! $route->getCallback()) {
             return $this->callAction($route);
         }

         return $this->callAnonymous($route);
    }




    /**
     * @throws BadControllerException
    */
    private function callAction(Route $route)
    {
        return $this->response(
            $this->app->callAction(
                $route->getController(),
                $route->getAction(),
                $route->getMatches()
            )
        );
    }




    /**
     * @param Route $route
     * @return JsonResponse|Response
    */
    private function callAnonymous(Route $route)
    {
        return $this->response(
            $this->app->callAnonymous(
                $route->getCallback(),
                $route->getMatches()
            )
        );
    }





    /**
     * @param $response
     * @return JsonResponse|Response
    */
    private function response($response)
    {
        if ($response instanceof Response) {
            return $response;
        } elseif (is_array($response)) {
            return new JsonResponse($response);
        }

        return new Response($response);
    }
}