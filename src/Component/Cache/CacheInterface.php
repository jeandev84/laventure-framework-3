<?php
namespace Laventure\Component\Cache;


/**
 * CacheInterface
*/
interface CacheInterface
{

    /**
     * Set cache
     *
     * @param $key
     * @param $data
     * @return mixed
    */
    public function set($key, $data);




    /**
     * Get data from the cache by given key
     *
     * @param $key
     * @return mixed
    */
    public function get($key);




    /**
     * Delete the specified data from the cache by given key
     *
     * @param $key
     * @return mixed
    */
    public function delete($key);




    /**
     * Check if the specific cache key exist
     *
     * @param $key
     * @return mixed
    */
    public function exists($key);
}