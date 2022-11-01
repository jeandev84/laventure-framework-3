<?php
namespace Laventure\Foundation\Service;

use Laventure\Component\FileSystem\FileSystem;
use Laventure\Foundation\Service\Cache\Cache;
use Laventure\Foundation\Service\Cache\CacheFactory;

/**
 * Storage
*/
class Storage
{

     /**
      * @var FileSystem
     */
     protected $filesystem;



     /**
      * @var CacheFactory
     */
     protected $cacheFactory;



     /**
      * @param $storagePath
     */
     public function __construct($storagePath = null)
     {
          $this->filesystem   = new FileSystem($storagePath);
          $this->cacheFactory = new CacheFactory($this->filesystem);
     }



     /**
      * @param $cacheType
      * @return Cache
     */
     public function cache($cacheType = null): Cache
     {
          return $this->cacheFactory->make($cacheType);
     }
}