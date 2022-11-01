<?php
namespace Laventure\Component\Container\Provider\Contract;


/**
 * BootableServiceProvider
*/
interface BootableServiceProvider
{
    /**
     * Boot service provider
     *
     * @return mixed
    */
    public function boot();
}