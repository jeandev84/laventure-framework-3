<?php
namespace Laventure\Foundation\Service\Cache;

use Laventure\Component\FileSystem\FileSystem;
use Laventure\Foundation\Service\Cache\Types\ApcCache;
use Laventure\Foundation\Service\Cache\Types\FileCache;
use Laventure\Foundation\Service\Cache\Types\MemoryCache;
use Laventure\Foundation\Service\Cache\Types\SplCache;

/**
 * CacheFactory
*/
class CacheFactory
{

      /**
       * @var FileSystem
      */
      protected $filesystem;


      /**
       * @param FileSystem $fileSystem
      */
      public function __construct(FileSystem $fileSystem)
      {
           $this->filesystem = $fileSystem;
      }



      /**
       * @param string|null $cacheTypeName
       * @return Cache
      */
      public function make(string $cacheTypeName = null): Cache
      {
            $cacheTypeDefault = new FileCache($this->filesystem);

            return [
                CacheType::FileType   => $cacheTypeDefault,
                CacheType::ApcType    => new ApcCache($this->filesystem),
                CacheType::MemoryType => new MemoryCache($this->filesystem),
                CacheType::SplType    => new SplCache($this->filesystem)
            ][$cacheTypeName] ?? $cacheTypeDefault;
      }
}