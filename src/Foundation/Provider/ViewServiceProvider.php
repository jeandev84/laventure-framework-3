<?php
namespace Laventure\Foundation\Provider;


use Laventure\Component\Container\Provider\ServiceProvider;
use Laventure\Component\FileSystem\FileSystem;
use Laventure\Component\Templating\Asset\Asset;
use Laventure\Component\Templating\Renderer\Renderer;
use Laventure\Component\Templating\Renderer\RendererInterface;


/**
 * ViewServiceProvider
*/
class ViewServiceProvider extends ServiceProvider
{


    /**
     * @var array
    */
    protected $provides = [
        Renderer::class => ['view', RendererInterface::class],
        Asset::class    => ['asset']
    ];





    /**
     * @inheritDoc
    */
    public function register()
    {
         $this->app->singleton(Renderer::class, function (FileSystem $fs) {

              /* $render = new Renderer($fs->locate('/resources/views/')); */

              $render = $this->app->make(Renderer::class, [
                  'root' => $fs->locate('/resources/views/')
              ]);

              $render->layout('layouts/default');
              return $render;
         });


         $this->app->singleton(Asset::class, function () {
              return $this->app->make(Asset::class, [
                  'url' => env('APP_URL')
              ]);
         });
    }



    private function renderPath()
    {

    }
}