<?php
namespace Laventure\Component\Console\Command\Contract;

use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;


/**
 * UndoableCommandInterface
*/
interface UndoableCommandInterface
{

      /**
       * Reverse or Rollback command
       *
       * @param InputInterface $input
       * @param OutputInterface $output
       * @return mixed
      */
      public function undo(InputInterface $input, OutputInterface $output);
}