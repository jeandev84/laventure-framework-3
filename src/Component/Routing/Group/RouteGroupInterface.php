<?php
namespace Laventure\Component\Routing\Group;


interface RouteGroupInterface
{

    const PREFIX     = 'prefix';
    const MODULE     = 'module';
    const NAME       = 'name';
    const MIDDLEWARE = 'middlewares';


    /**
     * Map routes
     *
     * @param $router
     * @return mixed
    */
    public function map($router);



    /**
     * Get route group attributes
     *
     * @return mixed
    */
    public function getAttributes();




    /**
     * Flush all actions after mapping routes
     *
     * @return mixed
    */
    public function refresh();
}