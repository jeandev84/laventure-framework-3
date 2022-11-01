<?php
namespace Laventure\Foundation\Service\Cache;


use Laventure\Component\FileSystem\FileSystem;


/**
 * Cache
*/
abstract class Cache implements Cacheable
{

      /**
       * @var FileSystem
      */
      protected $fileSystem;



      /**
       * @var string
      */
      protected $cacheExtension;




      /**
       * @param FileSystem $fileSystem
       * @param string $cacheExtension
      */
      public function __construct(FileSystem $fileSystem, string $cacheExtension = 'txt')
      {
            $this->fileSystem     = $fileSystem;
            $this->cacheExtension = $cacheExtension;
      }





      /**
       * @param $path
       * @return void
      */
      public function root($path)
      {
           $this->fileSystem->root($path);
      }




      /**
       * Set cache directory
       *
       * @param $path
       * @return $this
      */
      public function saveTo($path): self
      {
           $this->fileSystem->rootTo($path);

           return $this;
      }




      /**
       * @param $extension
       * @return $this
      */
      public function cacheExtension($extension): self
      {
           $this->cacheExtension = $extension;

           return $this;
      }




      /**
       * @return string
      */
      public function path(): string
      {
          return $this->fileSystem->basePath();
      }




      /**
       * Generate full path to cache
       *
       * @param $name
       * @return string
      */
      public function cacheTo($name): string
      {
           return $this->fileSystem->locate($this->cacheFilename($name));
      }





      /**
       * @param $name
       * @return string
      */
      public function cacheFilename($name): string
      {
           return sprintf('%s.%s', md5($name), trim($this->cacheExtension, '.'));
      }




      /**
       * @param $key
       * @return bool
      */
      public function exists($key): bool
      {
           return $this->fileSystem->exists($this->cacheFilename($key));
      }




      /**
       * @param $key
       * @return bool
       */
      public function delete($key): bool
      {
           return $this->fileSystem->remove($this->cacheFilename($key));
      }
}