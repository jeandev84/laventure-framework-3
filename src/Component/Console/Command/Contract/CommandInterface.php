<?php
namespace Laventure\Component\Console\Command\Contract;


/**
 * CommandInterface
*/
interface CommandInterface extends ExecutableCommandInterface
{

      /**
       * Return name of command
       *
       * @return string
      */
      public function getName(): string;
}