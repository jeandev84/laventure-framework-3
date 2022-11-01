<?php
namespace Laventure\Foundation\Service\Cache\Types;

use Laventure\Foundation\Service\Cache\Cache;
use Laventure\Foundation\Service\Cache\Exception\FileCacheException;


/**
 * FileCache
*/
class FileCache extends Cache
{

    /**
     * @inheritDoc
     * @param int $duration  | that is the end time of cache file
    */
    public function set($key, $data, int $duration = 3600)
    {
          $content = serialize(['data'=> $data, 'duration' => time() + $duration]);

          if (! $this->fileSystem->write($this->cacheFilename($key), $content)) {
                $this->createFileCacheException("Something went wrong during caching {$key}");
          }

          return true;
    }




    /**
     * @inheritDoc
    */
    public function get($key)
    {
        $cacheFilename = $this->cacheFilename($key);

        if (! $this->exists($key)) {
             return false;
        }

        $content = unserialize($this->fileSystem->read($cacheFilename));

        return time() <= $content['duration'] ? $content['data'] : $this->delete($key);
    }




    /**
     * @param $message
     * @return mixed
    */
    public function createFileCacheException($message)
    {
         return (function () use ($message) {
              throw new FileCacheException($message);
         })();
    }
}