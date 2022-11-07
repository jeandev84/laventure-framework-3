<?php
namespace Laventure\Component\Console\Input\Contract;


use Laventure\Component\Console\Input\InputDefinition;

/**
 * InputInterface
*/
interface InputInterface
{

      /**
       * Parse input tokens
       *
       * This  method implements setting arguments, options, flags ...
       *
       * @param array $tokens
       * @return mixed
      */
      public function parseTokens(array $tokens);




      /**
       * Return all inputs parsed
       *
       * Example : $tokens = [arg0, arg1, arg2, option0, option1, flag0, flag1 ...]
       *
       * @return array
      */
      public function getTokens(): array;






      /**
       * Return  first parsed argument
       *
       * Example: php console arg0
       *
       * @return mixed
      */
      public function getFirstArgument();






      /**
       * Return given name argument or default argument.
       *
       * @param $name
       * @return mixed
      */
      public function getArgument($name = null);





      /**
       * Determine if the given argument name exist.
       *
       * @param $name
       * @return mixed
      */
      public function hasArgument($name);





      /**
       * Return all parses arguments
       *
       * @return array
      */
      public function getArguments(): array;






      /**
       * @param $name
       * @param $value
       * @return mixed
      */
      public function setOption($name, $value);






      /**
       * Set option shortcut
       *
       * @param $name
       * @param $value
       * @return mixed
      */
      public function shortcutOption($name, $value);






      /**
       * Return parsed option
       *
       *
       * @param $name
       * @return mixed
      */
      public function getOption($name);





      /**
       * Determine if the given option name exist.
       *
       *
       * @param $name
       * @return mixed
      */
      public function hasOption($name);





      /**
       * Determine if given argument is flag
       * Example :
       *  $ php console -shortFlag --longFlag
       *
       * @param $name
       * @return mixed
      */
      public function hasFlag($name);






      /**
       * Return all parsed options
       *
       *
       * @return mixed
      */
      public function getOptions();






      /**
       * Return name of compiled file interactive
       *
       *
       * @return mixed
      */
      public function getInteractive();






      /**
       * Determine if compiled file exist
       *
       *
       * @return bool
      */
      public function isInteractive(): bool;




      /**
       * @param InputDefinition $inputs
       * @return mixed
      */
      public function validate(InputDefinition $inputs);
}