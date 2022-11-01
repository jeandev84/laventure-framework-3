<?php
namespace Laventure\Component\Cache;

class CacheManager
{


      /**
       * @var CacheInterface
      */
      protected $cacheable;




      /**
       * @param CacheInterface $cacheable
      */
      public function __construct(CacheInterface $cacheable)
      {
           $this->cacheable = $cacheable;
      }
}