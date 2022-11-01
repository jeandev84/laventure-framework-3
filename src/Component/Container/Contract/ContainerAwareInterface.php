<?php
namespace Laventure\Component\Container\Contract;

use Laventure\Component\Container\Container;


/**
 * ContainerInterface
*/
interface ContainerAwareInterface
{
     /**
      * @param Container $container
      * @return mixed
     */
     public function setContainer(Container $container);



     /**
      * @return Container
     */
     public function getContainer(): Container;
}