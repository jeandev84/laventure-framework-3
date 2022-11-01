<?php
namespace Laventure\Component\Console\Input;

use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Input\Exception\InputArgvException;


/**
 * Input
*/
abstract class InputArgv implements InputInterface
{

      /**
       * Get interactive name
       *
       * @var string
      */
      protected $interactive;



     /**
      * First argument
      *
      * @var string
     */
     protected $firstArgument;




     /**
      * store all parsed arguments
      *
      * @var array
     */
     protected $arguments = [];





     /**
      * store all parsed options
      *
      * @var array
     */
     protected $options = [];




     /**
      * @var array
     */
     protected $shortcuts = [];




     /**
      * store all parsed flags
      *
      * @var array
     */
     protected $flags = [];




     /**
      * @var array
     */
     protected $tokens = [];



     /**
      * Input Constructor.
      *
      * @param array $tokens
     */
     public function __construct(array $tokens)
     {
           $this->tokens = $tokens;

           $this->interactive = array_shift($tokens);

           $this->setFirstArgument(array_shift($tokens));

           $this->parseTokens($tokens);
     }





     /**
      * @inheritdoc
     */
     public function getInteractive()
     {
          return $this->interactive;
     }





     /**
      * @inheritdoc
     */
     public function isInteractive(): bool
     {
          return is_null($this->interactive);
     }






     /**
      * @param $argument
      * @return $this
     */
     public function setFirstArgument($argument): self
     {
          $this->firstArgument = $argument;

          return $this;
     }




     /**
      * @inheritDoc
     */
     public function getFirstArgument()
     {
           return $this->firstArgument;
     }




     /**
      * @param $name
      * @return bool
     */
     public function hasArgument($name = null): bool
     {
          return isset($this->arguments[$name]);
     }





     /**
      * @inheritDoc
     */
     public function getArgument($name = null)
     {
         if ($this->hasArgument($name)) {
              return $this->arguments[$name];
         }


         if (! $this->hasDefaultArgument()) {
              if (isset($this->tokens[2]) && stripos($this->tokens[2], '=') !== false) {
                  $this->createInputArgvException("Invalid default argument. '{$this->tokens[2]}'");
              } else {
                  $this->createInputArgvException("Default argument is required.");
              }
         }

         return $this->arguments[0];
     }





     /**
      * @inheritDoc
     */
     public function getArguments(): array
     {
          return $this->arguments;
     }






     /**
      * @inheritDoc
     */
     public function getOption($name)
     {
         return $this->options[$name] ?? '';
     }





     /**
      * @inheritdoc
     */
     public function hasOption($name)
     {
          return isset($this->options[$name]);
     }





     /**
      * @inheritDoc
     */
     public function getOptions()
     {
         return $this->options;
     }




     /**
      * @inheritDoc
     */
     public function flag($name)
     {
          return $this->flags[$name] ?? null;
     }




     /**
      * @param $name
      * @return bool
     */
     public function hasFlag($name): bool
     {
          return isset($this->flags[$name]);
     }




    /**
      * @inheritdoc
     */
     public function getFlags()
     {
         return $this->flags;
     }




     /**
      * @return array
     */
     public function getTokens(): array
     {
         return $this->tokens;
     }




     /**
      * @return int
     */
     public function count(): int
     {
         return count($this->tokens);
     }





     /**
      * @return bool
     */
     public function hasDefaultArgument(): bool
     {
        return isset($this->arguments[0]);
     }






     /**
      * @param $message
      * @return InputArgvException
     */
     protected function createInputArgvException($message): InputArgvException
     {
          return (function () use ($message) {
               throw new InputArgvException($message);
          })();
     }




     /**
      * @inheritDoc
     */
     abstract public function parseTokens($tokens);

}