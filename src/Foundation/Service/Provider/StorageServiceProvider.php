<?php
namespace Laventure\Foundation\Service\Provider;

use Laventure\Component\Cache\CacheInterface;
use Laventure\Component\Container\Provider\ServiceProvider;
use Laventure\Foundation\Service\Cache\Cache;
use Laventure\Foundation\Service\Cache\Cacheable;
use Laventure\Foundation\Service\Storage;

/**
 * StorageServiceProvider
*/
class StorageServiceProvider extends ServiceProvider
{

    /**
     * @inheritdoc
    */
    protected $provides = [
        Storage::class        => ['storage'],
        CacheInterface::class => ['cache', Cacheable::class, Cache::class]
    ];



    /**
     * @inheritDoc
    */
    public function register()
    {
         $this->app->singleton(Storage::class, function () {
            return $this->app->make(Storage::class);
         });

         $this->app->singleton(CacheInterface::class, function () {
               /** @var Cache $cache */
               $cache = $this->app['storage']->cache();
               $cache->root(app()->path('/temp/cache/framework'));
               return $cache;
         });

         // bind FileCacheInterface
         // bind MemoryCacheInterface
         // bind ApcCacheInterface
         // bind SplCacheInterface
    }
}