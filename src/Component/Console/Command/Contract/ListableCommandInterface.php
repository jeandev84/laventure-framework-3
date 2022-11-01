<?php
namespace Laventure\Component\Console\Command\Contract;

use Laventure\Component\Console\Command\Command;

/**
 * ListableCommandInterface
*/
interface ListableCommandInterface
{

      /**
       * Set all available commands
       *
       * @param Command[] $commands
       * @return mixed
     */
     public function setCommands(array $commands);





     /**
      * @return mixed
     */
     public function listCommands();
}