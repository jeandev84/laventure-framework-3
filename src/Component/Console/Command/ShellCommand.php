<?php
namespace Laventure\Component\Console\Command;


use Laventure\Component\Console\Command\Contract\ShellCommandInterface;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;

/**
 * @class ShellCommand
*/
class ShellCommand extends Command implements ShellCommandInterface
{
      /**
       * @param $command
       * @return false|string|null
      */
      public function exec($command)
      {
           return shell_exec($command);
      }
}