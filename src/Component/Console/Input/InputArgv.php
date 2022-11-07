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
      * @param $value
      * @return void
     */
     public function setArgument($name, $value)
     {
          $this->arguments[$name] = $value;
     }




     /**
      * @param $name
      * @return bool
     */
     public function hasArgument($name): bool
     {
          return isset($this->arguments[$name]);
     }





     /**
      * @inheritDoc
     */
     public function getArgument($name = null)
     {
         if ($name && $this->hasArgument($name)) {
              return $this->arguments[$name];
         }

         $argument = array_shift($this->arguments);

         if (! $argument) {
             $this->abortIf("Default argument is required.");
         }

         return $argument;
     }





     /**
      * @inheritDoc
     */
     public function getArguments(): array
     {
          return $this->arguments;
     }





     /**
      * @param $name
      * @param $value
      * @return void
     */
     public function setOption($name, $value)
     {
          $this->options[$name] = $value;
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
      * @param $name
      * @param $value
      * @return void
     */
     public function shortcutOption($name, $value)
     {
          $this->shortcuts[$name] = $value;
     }




     /**
      * @param $name
      * @return bool
     */
     public function hasFlag($name): bool
     {
          return $this->getOption($name) === $name;
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
      * @param $message
      * @return InputArgvException
     */
     protected function abortIf($message): InputArgvException
     {
          return (function () use ($message) {
               throw new InputArgvException($message);
          })();
     }





     /**
      * @inheritdoc
     */
     public function validate(InputDefinition $inputs)
     {
         return $this->validateArguments($inputs->getArguments()) && $this->validateOptions($inputs->getOptions());
     }






     /**
      * Validate arguments
      *
      * @param InputArgument[] $arguments
      * @return bool
     */
     private function validateArguments(array $arguments): bool
     {
          if (! empty($arguments)) {
               foreach ($this->arguments as $name => $value) {
                    if (! isset($arguments[$name])) {
                        $message = "What does it mean [{$name}={$value}] ?";
                        if (is_int($name)) {
                            $message = "May be you forgot to assign [{$value}] like [{$value}=something]  ?";
                        }
                        $this->abortIf("Invalid argument. {$message}");
                    }
               }

               foreach ($arguments as $index => $argument) {

                    $default = $argument->getDefault();

                    if ($default && $this->getArgument($index) === $index) {
                       $this->setArgument($index, $default);
                    }

                    if (! $argument->getDefault()) {
                        if (! $this->hasArgument($index) && $argument->isRequired()) {
                            $this->abortIf("Argument '{$index}' is required");
                        }
                    }
               }
          }

          return true;
     }






     /**
      * Validate options
      *
      * @param InputOption[] $options
      * @return bool
     */
     private function validateOptions(array $options): bool
     {
          if (! empty($options)) {

              foreach ($this->options as $key => $value) {
                   if (! isset($options[$key])) {
                       $this->abortIf("Invalid option name : '{$key}'");
                   } else {
                       $default =  $options[$key]->getDefault();
                       if($default && $key === $value) {
                           $this->setOption($key, $default);
                       }
                   }
              }

              foreach ($options as $index => $option) {

                   $name     = $option->getName();
                   $shortcut = $option->getShortcut();

                   if ($shortcut) {

                       if ($this->hasOption($shortcut)) {
                           $this->setOption($name, $this->getOption($shortcut));
                       }

                       $this->setOption($shortcut, $this->getOption($name));
                       $this->shortcutOption($shortcut, $name);
                   }

                   if ($option->isRequired()) {
                       if (! $this->hasOption($index) || ! $this->hasOption($name)) {
                           $message = $shortcut ? "--{$name} or -{$shortcut}" : "--$name";
                           $this->abortIf("Option '$message' is required");
                       }
                   }
              }
          }

          return true;
     }





     /**
      * @inheritDoc
     */
     abstract public function parseTokens($tokens);
}