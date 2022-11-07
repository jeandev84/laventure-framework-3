<?php
namespace Laventure\Component\Console\Input;


/**
 * InputDefinition
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
      * @param $name
      * @return bool
     */
     public function hasArgument($name): bool
     {
          return isset($this->arguments[$name]);
     }






     /**
      * @param $name
      * @return InputArgument|null
     */
     public function getArgument($name): ?InputArgument
     {
          return $this->arguments[$name] ?? null;
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
      * Add new input option
      *
      * @param InputOption $option
      * @return $this
     */
     public function addOption(InputOption $option): self
     {
          $name = $option->getName();

          if ($shortcut = $option->getShortcut()) {
               $this->options[$shortcut] = $option;
          }

          $this->options[$name] = $option;

          return $this;
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
      * @param $name
      * @return InputOption|null
     */
     public function getOption($name): ?InputOption
     {
          return $this->options[$name] ?? null;
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
}