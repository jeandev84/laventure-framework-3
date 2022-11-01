<?php
namespace Laventure\Component\Console\Output\Contract;



/**
 * OutputInterface
*/
interface OutputInterface
{


     /**
      * Write message inline
      *
      * @param $message
      * @return mixed
     */
     public function write($message);




     /**
      * Write and go to the new line
      *
      * @param $message
      * @return mixed
     */
     public function writeln($message);





     /**
      * Print messages
      *
      * @return string
     */
     public function __toString();








     /**
      * Show messages or do other things
      *  echo | print 'Result of execution'
      *
      * @return void
     */
     public function display();





    /**
     * @param $message
     * @return mixed
    */
    public function success($message);





    /**
     * @param $message
     * @return mixed
    */
    public function failure($message);





    /**
     * @param $message
     * @return mixed
    */
    public function invalid($message);





    /**
     * @param $message
     * @return mixed
    */
    public function warning($message);




    /**
     * @param $message
     * @return mixed
    */
    public function info($message);




    /**
     * @param $message
     * @return mixed
    */
    public function error($message);





    /**
     * @param $message
     * @return mixed
    */
    public function notice($message);
}