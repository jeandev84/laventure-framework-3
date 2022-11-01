<?php
namespace Laventure\Component\Container\Provider\Common;


use Laventure\Component\Container\Container;


/**
 * Class ServiceProviderTrait
 * @package Laventure\Component\Container\Provider\Common
 */
trait ServiceProviderTrait
{

    /**
     * @var Container
    */
    protected $app;




    /**
     * @var array
    */
    protected $provides = [];




    /**
     * @param Container $app
    */
    public function setContainer(Container $app)
    {
         $this->app = $app;
    }



    /**
     * @return Container
     */
    public function getContainer(): Container
    {
         return $this->app;
    }



    /**
     * @return array
    */
    public function getProvides(): array
    {
        return $this->provides;
    }



    /**
     * @param array $provides
     * @return void
    */
    public function setProvides(array $provides)
    {
         $this->provides = $provides;
    }



    /**
     * @return void
    */
    public function terminate() {}
}