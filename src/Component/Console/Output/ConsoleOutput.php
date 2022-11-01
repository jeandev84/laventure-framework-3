<?php
namespace Laventure\Component\Console\Output;

use Laventure\Component\Console\Helpers\QuestionHelper;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Component\Console\Output\Style\ConsoleStyle;


/**
 * ConsoleOutput
*/
class ConsoleOutput implements OutputInterface
{

    /**
     * @var ConsoleStyle
    */
    protected $style;




    /**
     * @var array
    */
    protected $messages = [];



    /**
     * ConsoleOutput
    */
    public function __construct()
    {
        $this->style = new ConsoleStyle();
    }




    /**
     * @return ConsoleStyle
    */
    public function getStyle(): ConsoleStyle
    {
         return $this->style;
    }



    /**
     * @inheritDoc
    */
    public function write($message): self
    {
        $this->messages[] = $message;

        return $this;
    }





    /**
     * @inheritDoc
    */
    public function writeln($message)
    {
        $this->messages[] = sprintf("%s%s", $message, PHP_EOL);

        return $this;
    }






    /**
     * @inheritdoc
    */
    public function __toString()
    {
        return join($this->messages);
    }





    /**
     * @return void
    */
    public function display()
    {
         print($this);
    }




    /**
     * @return QuestionHelper
    */
    public function ask(): QuestionHelper
    {
         return new QuestionHelper();
    }




    /**
     * @inheritDoc
    */
    public function success($message)
    {
         /*
          $textGreen = $this->style->textGreen($message)
          $bgGreen   = $this->style->bgGreen($message);
         */;

         return $this->writeln($this->style->textGreen($message));
    }





    /**
     * @inheritDoc
    */
    public function failure($message)
    {
         return $this->writeln($this->style->textRed($message));
    }




    /**
     * @inheritDoc
    */
    public function invalid($message)
    {
        // TODO: Implement invalid() method.
    }






    /**
     * @inheritDoc
    */
    public function error($message)
    {
        // TODO: Implement error() method.
    }





    /**
     * @inheritDoc
    */
    public function warning($message)
    {
        // TODO: Implement warning() method.
    }





    /**
     * @inheritDoc
    */
    public function info($message)
    {
        // TODO: Implement info() method.
    }




    /**
     * @inheritDoc
    */
    public function notice($message)
    {
         return $this->writeln("Notice [!] : {$message}");
    }
}