<?php
namespace Laventure\Component\Http\Session;


/**
 * SessionInterface
*/
interface SessionInterface
{


    /**
     * Start session
     *
     * @return mixed
    */
    public function start();



    /**
     * Set session
     *
     * @param $name
     * @param $value
     * @return mixed
    */
    public function set($name, $value);




    /**
     * Determine if the given name exist in session
     *
     * @param $name
     * @return mixed
    */
    public function has($name);




    /**
     * Get session by given name
     *
     * @param $name
     * @param $default
     * @return mixed
    */
    public function get($name, $default = null);




    /**
     * Remove session by given name
     *
     * @param $name
     * @return mixed
    */
    public function forget($name);





    /**
     * Get all sessions
     *
     * @return mixed
    */
    public function all();





    /**
     * remove all sessions
     *
     * @return mixed
    */
    public function destroy();




    /**
     * @param $name
     * @param $message
     * @return mixed
    */
    public function setFlash($name, $message);




    /**
     * @param $name
     * @return mixed
    */
    public function getFlash($name);





    /**
     * @return mixed
    */
    public function getFlashes();
}