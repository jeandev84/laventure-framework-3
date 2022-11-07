<?php
namespace Laventure\Foundation\Service\Provider;


use Laventure\Component\Container\Provider\Contract\BootableServiceProvider;
use Laventure\Component\Container\Provider\ServiceProvider;
use Laventure\Component\Templating\Asset\Asset;
use Laventure\Component\Templating\Renderer\Renderer;
use Laventure\Component\Templating\Renderer\RendererInterface;
use Laventure\Foundation\Factory\Views\ViewFactory;


/**
 * ViewServiceProvider
*/
class ViewServiceProvider extends ServiceProvider implements BootableServiceProvider
{


    /**
     * @var array
    */
    protected $provides = [
        Renderer::class => ['view', RendererInterface::class],
        Asset::class    => ['asset']
    ];



    /**
     * @inheritdoc
    */
    public function boot()
    {
        $this->app->bind('view.layout', \config()->get('view.layout'));
    }





    /**
     * @inheritDoc
    */
    public function register()
    {
         $this->app->singleton(Renderer::class, function () {

              $viewPath  = \fs()->locate(\config()->get('view.root'));
              $extension = \config()->get('view.extension');
              $render    = ViewFactory::create($viewPath, $extension);

              $render->compress(\config()->get('view.compress'));
              $render->cachePath(fs()->locate('/temp/cache/app/views/'));

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