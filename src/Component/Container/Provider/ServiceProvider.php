<?php
namespace Laventure\Component\Container\Provider;

use Laventure\Component\Container\Provider\Contract\ServiceProviderInterface;
use Laventure\Component\Container\Provider\Common\ServiceProviderTrait;


/**
 * ServiceProvider
*/
abstract class ServiceProvider implements ServiceProviderInterface
{
     use ServiceProviderTrait;


     /**
      * @return string
     */
     public function getName(): string
     {
          return (new \ReflectionClass($this))->getShortName();
     }
}