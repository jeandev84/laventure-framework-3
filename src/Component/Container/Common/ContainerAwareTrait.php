<?php
namespace Laventure\Component\Container\Common;


use Laventure\Component\Container\Container;


/**
 * @see ContainerAwareTrait
 *
 * @package Laventure\Component\Container\Common
 */
trait ContainerAwareTrait
{

    /**
     * @var Container
    */
    protected $container;




    /**
     * @param Container $container
     * @return void
     */
    public function setContainer(Container $container)
    {
         $this->container = $container;
    }



    /**
     * @return Container
    */
    public function getContainer(): Container
    {
        return $this->container;
    }
}