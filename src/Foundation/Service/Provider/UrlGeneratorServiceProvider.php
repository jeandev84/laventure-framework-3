<?php
namespace Laventure\Foundation\Service\Provider;

use Laventure\Component\Container\Provider\ServiceProvider;
use Laventure\Component\Routing\Generator\UrlGenerator;
use Laventure\Component\Routing\Generator\UrlGeneratorInterface;

class UrlGeneratorServiceProvider extends ServiceProvider
{


    /**
     * @var \string[][]
    */
    protected $provides = [
        UrlGenerator::class => ['url', UrlGeneratorInterface::class],
    ];





    /**
     * @inheritDoc
    */
    public function register()
    {
        $this->app->singleton(UrlGenerator::class, function () {
            return $this->app->make(UrlGenerator::class, [
                'networkDomain' => env('APP_URL')
            ]);
        });
    }
}