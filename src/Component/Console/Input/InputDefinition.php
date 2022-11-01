<?php
namespace Laventure\Component\Console\Input;

use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Input\Validators\Common\InputParameterValidator;
use Laventure\Component\Console\Input\Validators\InputArgumentValidator;
use Laventure\Component\Console\Input\Validators\InputOptionValidator;

/**
 * InputBag
*/
class InputDefinition
{

     /**
      * @var InputArgument[]
     */
     protected $arguments = [];



     /**
      * @var InputOption[]
     */
     protected $options = [];





     /**
      * @var array
     */
     protected $errors = [];





     /**
      * Add new input argument
      *
      * @param InputArgument $argument
      * @return $this
     */
     public function addArgument(InputArgument $argument): self
     {
          $this->arguments[$argument->getName()] = $argument;

          return $this;
     }




     /**
      * Return all input arguments
      *
      * @return InputArgument[]
     */
     public function getArguments(): array
     {
          return $this->arguments;
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
      * @return bool
     */
     public function hasArguments(): bool
     {
          return ! empty($this->arguments);
     }




     /**
      * Return input argument by given name
      *
      * @param string $name
      * @return InputArgument|null
     */
     public function getArgument(string $name): ?InputArgument
     {
          return $this->arguments[$name] ?? null;
     }





     /**
      * Add new input option
      *
      * @param InputOption $option
      * @return $this
     */
     public function addOption(InputOption $option): self
     {
          $this->options[$option->getName()] = $option;

          return $this;
     }





     /**
      * Return all input options.
      *
      * @return InputOption[]
     */
     public function getOptions(): array
     {
          return $this->options;
     }




     /**
      * @return bool
     */
     public function hasOptions(): bool
     {
         return ! empty($this->options);
     }




     /**
      * Return input option by given name
      *
      * @param string $name
      * @return InputOption|null
     */
     public function getOption(string $name): ?InputOption
     {
         return $this->options[$name] ?? null;
     }





     /**
      * @param $name
      * @return bool
     */
     public function hasOption($name): bool
     {
          return isset($this->options[$name]);
     }





     /**
      * @param InputInterface $input
      * @return bool
     */
     public function validate(InputInterface $input): bool
     {
         return $this->validateArguments($input) && $this->validateOptions($input);
     }





     /**
      * @return array
     */
     public function getErrors(): array
     {
          return $this->errors;
     }




     /**
      * @param InputInterface $input
      * @return bool
     */
     public function validateArguments(InputInterface $input): bool
     {
         if ($this->hasArguments()) {

             foreach ($input->getArguments() as $name => $argument) {
                 if (! $this->hasArgument($name)) {
                     $message = "What does it mean [{$name}={$argument}] ?";
                     if (is_int($name)) {
                        $message = "May be you forgot to assign [{$argument}] like [{$argument}=something]  ?";
                     }
                     return $this->addErrors("Invalid argument. {$message}");
                 }
             }

             foreach ($this->getArguments() as $name => $argument) {
                 if (! $input->hasArgument($name) && $argument->isRequired()) {
                     return $this->addErrors("Argument '{$name}' is required");
                 }
             }
         }

         return true;
     }






     /**
      * @param InputInterface $input
      * @return bool
     */
     public function validateOptions(InputInterface $input): bool
     {
         if ($this->hasOptions()) {

             foreach ($input->getOptions() as $name => $option) {
                 if (! $this->hasOption($name)) {
                     return $this->addErrors("Invalid option name : '{$name}'");
                 }
             }

             foreach ($this->getOptions() as $name => $option) {
                 if (! $input->hasOption($name) && $option->isRequired()) {
                     return $this->addErrors("Option '{$name}' is required");
                 }
             }
         }

         return true;
     }







    /**
     * @param $errorMessage
     * @return false
    */
    private function addErrors($errorMessage): bool
    {
        $this->errors[] = $errorMessage;

        return false;
    }
}