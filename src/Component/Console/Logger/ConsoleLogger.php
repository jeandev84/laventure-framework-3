<?php
namespace Laventure\Component\Console\Logger;

use Exception;
use Laventure\Component\Console\Console;
use Laventure\Component\Console\Output\Style\ConsoleStyle;


/**
 * @class ConsoleLogger
*/
class ConsoleLogger implements ConsoleLoggerInterface
{


    /**
     * @var Console
    */
    protected $console;




    /**
     * @var array
    */
    protected $messages = [];





    /**
     * ConsoleLogger constructor
     *
     * @param Console $console
    */
    public function __construct(Console $console)
    {
          $this->console = $console;
    }





    /**
     * @inheritDoc
    */
    public function log(Exception $e)
    {
         $style = $this->console->getStyle();

         $this->console->print(PHP_EOL);
         $this->console->print($style->bgRed($e->getMessage()));
         $this->console->print(PHP_EOL.PHP_EOL);

         exit(1);
    }
}