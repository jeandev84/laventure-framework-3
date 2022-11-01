<?php
namespace Laventure\Component\Container\Provider\Contract;

/**
 * ServiceProviderInterface
*/
interface ServiceProviderInterface
{
     /**
      * Register service in container
      *
      * @return mixed
     */
     public function register();
}