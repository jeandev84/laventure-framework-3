<?php
namespace Laventure\Component\Database\Connection\Query;


/**
 *
*/
interface QueryHydrateInterface
{
    /**
     * Fetch all results
     *
     * @return mixed
    */
    public function all();


    /**
     * Fetch One
     *
     * @return mixed
    */
    public function one();


    /**
     * Fetch column
     *
     * @return mixed
    */
    public function columns();


    /**
     * Fetch object
     *
     * @return mixed
    */
    public function object();



    /**
     * @return mixed
    */
    public function count();




    /**
     * @return mixed
    */
    public function asArray();
}