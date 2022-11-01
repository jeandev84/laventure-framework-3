<?php
use Laventure\Component\Container\Container;
use Laventure\Component\Http\Response\JsonResponse;
use Laventure\Component\Http\Response\RedirectResponse;
use Laventure\Component\Http\Response\Response;
use Laventure\Component\Routing\Generator\UrlGenerator;
use Laventure\Component\Templating\Renderer\Renderer;
use Laventure\Foundation\Application;
use Laventure\Foundation\Facade\Routing\Route;
use Laventure\Foundation\Facade\Routing\Url;
use Laventure\Foundation\Facade\Templating\Asset;
use Laventure\Foundation\Facade\Templating\View;

/*
|------------------------------------------------------------------
|   Get application
|   app()
|------------------------------------------------------------------
*/

if(! function_exists('app')) {

    /**
     * @param string|null $abstract
     * @param array $parameters
     * @return Application|object
     * @throws
     */
    function app(string $abstract = null, array $parameters = []): Application
    {
        $app = Container::getInstance();

        if(is_null($abstract)) {
            return $app;
        }

        return $app->make($abstract, $parameters);
    }
}





/*
|------------------------------------------------------------------
|   Get application
|   app_name()
|------------------------------------------------------------------
*/

if(! function_exists('app_name')) {

    function app_name(): string
    {
         return app()->getName();
    }
}




/*
|------------------------------------------------------------------
|   Get base path using in template
|------------------------------------------------------------------
*/

if(! function_exists('base_path')) {

    /**
     * Base Path
     * @param string $path
     * @return string
    */
    function base_path(string $path = ''): string
    {
        return app()->path($path);
    }
}




/*
|------------------------------------------------------------------
|   Get environment param
|   env('SECRET_KEY', 'some_hash')
|------------------------------------------------------------------
*/

if(! function_exists('env'))
{
    /**
     * Get item from environment or default value
     *
     * @param $key
     * @param null $default
     * @return array|string|null
    */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if(! $value) {
            return $default;
        }

        return $value;
    }
}





/*
|-----------------------------------------------------------------------------
|   Route
|   route('home')                => /page/home
|   route('demo', ['id' => 1])   => /page/demo/1
|-----------------------------------------------------------------------------
*/

if (! function_exists('route')) {

     /**
      * @param string $name
      * @param array $parameters
      * @return string
     */
     function route(string $name, array $parameters = []): string
     {
           return Route::generate($name, $parameters);
     }
}




/*
|-----------------------------------------------------------------------------
|   URL
|   url('home')                => http://localhost:8000/page/home
|   url('demo', ['id' => 1])   => http://localhost:8000/page/demo/1
|-----------------------------------------------------------------------------
*/

if (! function_exists('url')) {

    /**
     * @param string $name
     * @param array $parameters
     * @return string
    */
    function url(string $name, array $parameters = []): string
    {
         return Url::generate($name, $parameters);
    }
}



/*
|-----------------------------------------------------------------------------
|   Asset
|   asset('/css/app.css')                 => http://localhost:8000/css/app.css
|   asset('/js/app.js')                   => http://localhost:8000/js/app.js
|   asset('/uploads/thumb/img_001.png')   => http://localhost:8000/uploads/thumb/img_001.png
|-----------------------------------------------------------------------------
*/

if (! function_exists('asset')) {

    /**
     * @param string $to
     * @return string
    */
    function asset(string $to): string
    {
        return Asset::link($to);
    }
}




/*
|------------------------------------------------------------------
|   Render assets template
|
|   Example : assets(['/css/app.css', '/css/bootstrap/bootstrap.min.css'])
|   Example : assets(['/js/app.js', '/js/bootstrap/bootstrap.min.js', 'js/jquery/jquery.min.js'])
|   Example : assets() generate all available scripts and styles
|
|------------------------------------------------------------------
*/

if (! function_exists('assets')) {

    /**
     * @param array $files
     * @return string
    */
    function assets(array $files = []): string
    {
        return Asset::links($files);
    }
}


/*
|-----------------------------------------------------------------------------
|   Redirect
|   redirect()->home()
|   redirect()->to('contact')
|-----------------------------------------------------------------------------
*/




/*
|-----------------------------------------------------------------------------
|   Render template
|   view('demo.twig', ['email' => 'jeanyao@ymail.com', 'username' => 'yao']);
|-----------------------------------------------------------------------------
*/


if (! function_exists('view')) {

     /**
      * @param string $template
      * @param array $data
      * @return Response
     */
     function view(string $template, array $data = []): Response
     {
          /** @var Renderer $view */
          $view = app()->get('view');
          $view->layout(app()->get('view.layout'));

          return \response($view->render($template, $data));
     }
}



/*
|-----------------------------------------------------------------------------
|   Response
|
|   response('{'id': 1, 'content': 'some content here', Response::HTTP_OK, ['Accept' => 'application/json']);
|-----------------------------------------------------------------------------
*/

if (! function_exists('response')) {

    /**
     * @param $content
     * @param int $status
     * @param array $headers
     * @return Response
    */
    function response($content, int $status = 200, array $headers = []): Response
    {
        return new Response($content, $status, $headers);
    }
}




/*
|-----------------------------------------------------------------------------
|   JsonResponse
|
|   json([
|      'id' => 1,
|      'content' => 'some content here'
|   ], Response::HTTP_OK);
|-----------------------------------------------------------------------------
*/

if (! function_exists('json')) {

    /**
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return Response
    */
    function json(array $data, int $status = 200, array $headers = []): Response
    {
        return new JsonResponse($data, $status, $headers);
    }
}





/*
|-----------------------------------------------------------------------------
|   JsonResponse
|
|   json([
|      'id' => 1,
|      'content' => 'some content here'
|   ], Response::HTTP_OK);
|-----------------------------------------------------------------------------
*/

if (! function_exists('json')) {

    /**
     * @param null $path
     * @param array $headers
     * @return Response
    */
    function redirect($path = null, array $headers = []): Response
    {
          return new RedirectResponse($path, 301, $headers);
    }
}




/*
|-----------------------------------------------------------------------------
|   Render template
|   view('demo.twig', ['email' => 'jeanyao@ymail.com', 'username' => 'yao']);
|-----------------------------------------------------------------------------
*/


if (! function_exists('includePath')) {

    /**
     * @param string $path
     * @param array $data
     * @return mixed
    */
    function includePath(string $path, array $data = [])
    {
         return View::includePath($path, $data);
    }
}


