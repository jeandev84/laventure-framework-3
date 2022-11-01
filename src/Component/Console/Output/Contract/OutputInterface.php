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
      * Print messages
      *
      * @return void
     */
     public function print();




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