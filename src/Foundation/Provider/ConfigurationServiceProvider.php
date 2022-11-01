<?php
namespace Laventure\Foundation\Provider;

use Laventure\Component\Config\Config;
use Laventure\Component\Config\Loaders\ArrayLoader;
use Laventure\Component\Container\Provider\ServiceProvider;
use Laventure\Component\FileSystem\FileSystem;

/**
 *
*/
class ConfigurationServiceProvider extends ServiceProvider
{

    protected $provides = [
        Config::class => ['config']
    ];




    /**
     * @inheritDoc
    */
    public function register()
    {
        $this->app->singleton(Config::class, function (FileSystem $fs) {

             /** @var Config $config */
             $config = $this->app->factory(Config::class);
             $arrays = $fs->collection('/config/params/*.php')->configs();

             $config->load([
                 new ArrayLoader($arrays)
             ]);

             return $config;
        });

    }
}